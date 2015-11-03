var contentData = undefined;
var generator 	= undefined;

$(document).ready(function() {

	newSite();

	// Tabs
	$('#tab-template').click(function() {
        $('.tab').removeClass('selected');
        $(this).addClass('selected');

		$('.content').hide();
        $('#content-template').show();
    });
	$('#tab-pages').click(function() {
        $('.tab').removeClass('selected');
        $(this).addClass('selected');

		$('.content').hide();
        $('#content-pages').show();
    });
	$('#tab-modules').click(function() {
        $('.tab').removeClass('selected');
        $(this).addClass('selected');

		$('.content').hide();
        $('#content-modules').show();
    });

    // Sélection d'un template
    $('#content-template').on('click', '.template', function() {
    	if(!$(this).hasClass('selected'))
    		useTemplate($(this));
    });

    // Sélection d'un template
    $('#content-modules').on('click', '.module', function() {
    	toggleModule($(this));
    });

    // Exportation des données
    $('#exportForm').submit(function(e) {
    	e.preventDefault(); // Prevent default submit

    	if(validateDB())
    	{
    		$('#exportModal').modal('hide');
    		$('#loadingModal').modal('show');
    		exportData();
    	}
    });

    // Nouveau site
    $('#newSite').click(function() {
    	newSite();
    });

});

/**
 * Activation/Désactivation d'un module.
 */
function toggleModule(module)
{
	if(module.hasClass('selected'))
	{
		module.removeClass('selected');
		generator['modules'] = generator['modules'].filter(function(element) {
			return element.name !== module.find('span').last().html();
		});
	}
	else
	{
		module.addClass('selected');
		generator['modules'].push({
			'name': module.find('span').last().html()
		});
	}
}

/**
 * On charge les modules et les pages en fonction du template sélectionné.
 */
function useTemplate(template)
{
	$('.template').removeClass('selected');
    template.addClass('selected');

	generator['template'] = {
		'name': template.find('span').last().html(),
		'path': template.attr('data-path')
	};

	setPreview();

	// On récupère les données du bon template
	$.each(contentData.content, function(i, item) {
		if(item.name == generator['template']['name'])
		{
			var pages = $('#content-pages');
			var modules = $('#content-modules');

			// Modules
			modules.empty();
			if(item.modules == undefined || item.modules.length == 0)
			{
				modules.append($('<div>')
					.html('Ce template n\'embarque aucun module')
				);
			}
			else
			{
				$.each(item.modules, function(j, module) {
					// Load modules
					modules.append($('<div>')
		    			.attr('class', 'col-sm-12 col-md-6 col-lg-6')
		    			.append($('<div>')
		    				.attr('class', 'item module')
		    				.append($('<span>')
		    					.attr('class', 'glyphicon glyphicon-wrench')
		    				)
		    				.append($('<br>'))
		    				.append($('<span>')
		    					.html(module.name)
		    				)
		    			)
		    		);
				});
			}

			// Pages
			pages.empty();
			if(item.pages == undefined || item.pages.length == 0)
			{
				pages.append($('<div>')
					.html('Ce template ne contient aucune page')
				);
			}
			else
			{
				$.each(item.pages, function(name, category) {
					// Load category
					pages.append($('<div>')
						.html(name)
		    		);

					// Load pages
					$.each(category, function(j, page) {
						pages.append($('<div>')
			    			.attr('class', 'col-sm-12 col-md-6 col-lg-6')
			    			.append($('<div>')
			    				.attr('class', 'item page')
			    				.append($('<span>')
			    					.attr('class', 'glyphicon glyphicon-edit')
			    				)
			    				.append($('<br>'))
			    				.append($('<span>')
			    					.html(page.name)
			    				)
			    			)
			    		);
					});
				});
			}

			return false; //break;
		}
	});
}

function setPreview()
{
	$('#render-panel').attr('data', atob(generator['template']['path']) + '/preview.html');
}

/**
 * Remise par défaut des données du générateur.
 */
function resetGenerator()
{
	contentData = undefined;

	generator = {
		'template': {},
		'pages': [],
		'modules': [],
		'db': {}
	};

	$('#render-panel').empty();
	$('.tab').removeClass('selected');
	$('.module').removeClass('selected');
}

function newSite()
{
	resetGenerator();
	loadData();

	$('.content').hide();
	$('#tab-template').addClass('selected');
	$('#content-template').show();
}

/**
 * Chargement des données du générateur (les templates, leurs modules et leurs pages).
 */
function loadData()
{
	var templates 	= $('#content-template');
	var pages 		= $('#content-pages');
	var modules 	= $('#content-modules');

    $.ajax({
        url : '/ajax/load',
        dataType : 'json'
    })
    .success(function(data) {
    	contentData = data;
    	templates.empty();

    	// Load template
    	$.each(data.content, function(index, item) {
    		templates.append($('<div>')
    			.attr('class', 'col-sm-12 col-md-6 col-lg-6')
    			.append($('<div>')
    				.attr('class', 'item template')
    				.attr('data-path', item.path)
    				.append($('<img>')
    					.attr('src', atob(item.path) + '/icon.png')
    					.attr('alt', '[icon]')
    				)
    				.append($('<br>'))
    				.append($('<span>')
    					.html(item.name)
    				)
    			)
    		);

    		// On sélectionne le premier template comme template par défaut
    		if(index == 0)
    			useTemplate(templates.find('.template').last());
    	});
    });
}

function validateDB()
{
	if($('#DBHost').val() != '' && $('#DBName').val() != '' && $('#DBUser').val() != '' && $('#DBPass').val() != '')
	{
		generator['db'] = {
			'host': btoa($('#DBHost').val()),
			'name': btoa($('#DBName').val()),
			'user': btoa($('#DBUser').val()),
			'pass': btoa($('#DBPass').val())
		};
		return true;
	}
	return false;
}

/**
 * Envoi des données du site Web à générer et récupération de l'archive.
 */
function exportData()
{
    $.ajax({
    	method: 'POST',
        url : '/ajax/export',
        data : 'data=' + JSON.stringify({data: generator}),
        dataType : 'json'
    })
    .success(function(data) {
    	$('#loadingModal').modal('hide');
    	document.location.href = data.url;
    })
    .fail(function(data) {
    	$('#LoadingLabel').attr('style', 'color: red').html('Erreur d\'exportation');
    });
}