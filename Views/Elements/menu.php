<section class="jumbotron">
    <div class="row">
        <div id="left-menu">
            <span id="btn-menu" class="btn dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    <span class="glyphicon glyphicon-menu-hamburger"></span>
                    Menu
                </a>
                <ul class="dropdown-menu center" role="menu">
                    <li data-toggle="modal" data-target="#confirmModal">Nouveau site</li>
                    <li role="presentation" class="divider"></li>
                    <li data-toggle="modal" data-target="#exportModal">Exportation</li>
                </ul>
            </span>

            <hr />

            <div id="tabs" class="row">
                <div id="tab-template" class="col-xs-12 col-sm-12 col-md-4 col-lg-4 tab">
                    <div class="tab-content">
                        <span class="glyphicon glyphicon-object-align-top tab-icon"></span><br />
                        <span class="show-on-desktops">Style</span>
                    </div>
                </div>
                <div id="tab-pages" class="col-xs-12 col-sm-12 col-md-4 col-lg-4 tab">
                    <div class="tab-content">
                        <span class="glyphicon glyphicon-edit tab-icon"></span><br />
                        <span class="show-on-desktops">Pages</span>
                    </div>
                </div>
                <div id="tab-modules" class="col-xs-12 col-sm-12 col-md-4 col-lg-4 tab">
                    <div class="tab-content">
                        <span class="glyphicon glyphicon-wrench tab-icon"></span><br />
                        <span class="show-on-desktops">Modules</span>
                    </div>
                </div>
            </div>

            <div id="content-container">
                <div id="content-template" class="content row"></div>
                <div id="content-pages" class="content row"></div>
                <div id="content-modules" class="content row"></div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="Configuration" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="Configuration">Configuration de la base de données</h4>
            </div>
        
            <form class="form-horizontal" id="exportForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="DBHost" class="col-sm-3 control-label">Hôte</label>
                        <div class="col-sm-8">
                            <input type="text" id="DBHost" placeHolder="Adresse de la base de données" value="localhost" class="form-control" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="DBName" class="col-sm-3 control-label">Base de données</label>
                        <div class="col-sm-8">
                            <input type="text" id="DBName" placeHolder="Nom de la base de données" class="form-control" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="DBUser" class="col-sm-3 control-label">Utilisateur</label>
                        <div class="col-sm-8">
                            <input type="text" id="DBUser" placeHolder="Utilisateur de la base de données" class="form-control" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="DBPass" class="col-sm-3 control-label">Mot de passe</label>
                        <div class="col-sm-8">
                            <input type="password" id="DBPass" placeHolder="Mot de passe de la base de données" class="form-control" required />
                        </div>
                    </div>
                </div>
                    
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Exporter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="LoadingLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="LoadingLabel">Exportation en cours...</h4>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="ConfirmLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ConfirmLabel">Attention</h4>
            </div>
        
            <div class="modal-body">
                Êtes-vous certain de vouloir générer un nouveau site ?<br />
                Toutes les configurations effectuées jusqu'ici seront perdues.
            </div>
                
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-success" data-dismiss="modal" id="newSite">Confirmer</button>
            </div>
        </div>
    </div>
</div>