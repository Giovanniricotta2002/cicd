/**
 * Script JS spécifique à l'applicatif, ce script est destiné à être
 * appelé en dernier dans la pile des fichiers JS.
 *
 * @package openfoncier
 * @version SVN : $Id: script.js 6066 2016-03-01 11:11:26Z nhaye $
 */

/**
 * UUID utilisé pour détecter si ce fichier a été chargé.
 * 
 * Utilisé actuellement par le détecteur de bloqueur de pub.
 */
var app_script_t4Fv4a59uSU7MwpJ59Qp = true;

/**
 * Méthode exécutée au chargement de la page.
 * Permet, au rafraichissement de la page, d'avoir le focus des champs à saisir
 * et le bind des actions direct du portlet.
 *
 * @return {[type]} [description]
 */
function initBindFocus(){

    /**
     * Ajout du focus sur le champ login au chargement de la page.
     */
     $('#login_form #login').focus();

    /**
     * Spécifique à l'action affichage_reglementaire_attestation de la classe 
     * demande pour donner le focus sur le champ de recherche au chargement de
     * la page.
     */
     $('#affichage_reglementaire_attestation_form #dossier').focus();

    /**
     * WIDGET DASHBOARD - widget_recherche_dossier.
     *
     * Spécifique app/widget_recherche_dossier.php pour donner le
     * focus sur le champ de recherche au chargement de la page.
     */
     $('#widget_recherche_dossier_form #dossier').focus();

    /**
     * WIDGET DASHBOARD - widget_recherche_dossier_par_type.
     *
     * Spécifique app/widget_recherche_dossier_par_type.php pour donner le
     * focus sur le champ de recherche au chargement de la page.
     */
     $('#widget_recherche_dossier_par_type_form #dossier').focus();

   /**
    * Spécifique app/suivi_retours_de_consultation.php pour donner le focus sur le champ de
    * recherche au chargement de la page.
    */
   $('#suivi_retours_de_consultation_form #code_barres').focus();

    /**
    * Spécifique app/suivi_mise_a_jour_des_dates.php pour donner le focus sur le champ
    * instruction au chargement de la page si la date n'est pas vide.
    */
    if($('#suivi_mise_a_jour_des_dates_form #date').val()!="") {
        $('#suivi_mise_a_jour_des_dates_form #code_barres').focus();
    }
    
    /**
    * Spécifique app/suivi_envoi_lettre_rar.php pour donner le focus sur le champ
    * liste des codes barres d'instructions scannés au chargement de la page.
    */
    $('#suivi_envoi_lettre_rar_form #liste_code_barres_instruction').focus();

    /**
    * Spécifique app/suivi_mise_a_jour_des_dates.php pour donner le focus sur le champ
    * instruction au chargement de la page si la date n'est pas vide.
    */
    if($('#bordereau_envoi_maire #date').val()!="") {
        $('#bordereau_envoi_maire #code_barres').focus();
    }
    
    /**
     * Sur les widgets du tableau de bord, si on détecte un bloc d'aide
     * alors on le déplace dans le titre du widget (i).
     */
    $("#dashboard .widget-content div.widget-help").each(function(){
        widget = $(this).parent().parent().parent();
        header = widget.find(".widget-header");
        header.prepend($(this));
    });

    /**
     * Affichage d'un dialog pour les règles de calcul associés à l'action
     */
    $('.regle_action').dialog({
        autoOpen: false,
        show: "fade",
        hide: "fade",
        dialogClass: "alert",
        minHeight: 30,
        minWidth: 200
    });
    
    $('.wf_evenement_action').mouseover(
        function(){
            var id = $(this).attr("id");
            // Ajout d'une classe permettant de sélectionner les dialog du workflow
            if ($( "#regle_action"+ id ).length) {
                $(this).addClass("cursor-help")
            };
            $( "#regle_action"+ id ).parent().addClass("alert_regle_action");
            $( "#regle_action"+ id ).dialog({ position: { my: "left", at: "right", of: $(this) }, resizable: false });
            $( "#regle_action"+ id ).dialog("open");
            $(".ui-dialog-titlebar").hide();
        }
    );
    
    $('.wf_evenement_action').mouseleave(
        function(){
            var id = $(this).attr("id");
            $( "#regle_action"+ id ).dialog( "close" );
        }
    );

    /**
     * Plugin jquery qui bind les actions du formulaire dossier_instruction pour
     * ouvrir des overlay.
     *
     * @param string action Identifiant de l'action
     * @param string obj    Formulaire ouvert en overlay
     *
     * @return void
     */
    (function($){
        //Within this wrapper, $ is the jQuery namespace
        $.fn.bind_action_for_overlay = function(obj, width, height, callback, callbackParams, position, resizable) {
            if( typeof(width) == 'undefined' ){
                width = 'auto';
            }
            if( typeof(height) == 'undefined' ){
                height = 'auto';
            }
            if( typeof(callback) == 'undefined' ){
                callback = '';
            }
            if( typeof(callbackParams) == 'undefined' ){
                callbackParams = '';
            }
            if( typeof(position) == 'undefined' ){
                position = 'left top';
            }

            // bind de la function passée en arg sur l'event click des actions portlet
            $(this).off("click").on("click", function(event) {
                //
                elem_href = $(this).attr('href');
                if (elem_href != '#') {
                    $(this).attr('data-href', elem_href);
                    $(this).attr('href', '#');
                }
                //
                popupIt(obj, $(this).attr('data-href'), width, height, callback, callbackParams, position, resizable);
            });
            return $(this);
        }
    })(jQuery);

    // Bind actions formulaire de sélection des demandeurs à notifier depuis instruction
    $('a[id^=action-sousform-instruction][id$=-overlay_notification_manuelle]').each(function(){
        $(this).bind_action_for_overlay("instruction_notification_manuelle");
    });
    // Bind actions formulaire de sélection des services à notifier depuis instruction
    $('a[id^=action-sousform-instruction][id$=-overlay_notification_service_consulte]').each(function(){
        $(this).bind_action_for_overlay("instruction_notification_manuelle");
    });
    // Bind actions formulaire de sélection des tiers à notifier depuis instruction
    $('a[id^=action-sousform-instruction][id$=-overlay_notification_tiers_consulte]').each(function(){
        $(this).bind_action_for_overlay("instruction_notification_manuelle");
    });
    // Bind actions données techniques depuis dossier instruction
    $('a[id^=action-form-dossier_instruction][id$=-donnees_techniques]').each(function(){
        $(this).bind_action_for_overlay("donnees_techniques", "90%");
    });
    // Bind actions données techniques depuis dossier contentieux
    $('a[id^=action-form-dossier_contentieux][id$=-donnees_techniques]').each(function(){
        $(this).bind_action_for_overlay("donnees_techniques_contexte_ctx");
    });
    // Bind actions données techniques depuis sous-dossier
    $('a[id^=action-form-sous_dossier][id$=-donnees_techniques]').each(function(){
        $(this).bind_action_for_overlay("donnees_techniques");
    });
    // Bind actions rapport d'instruction depuis dossier instruction
    $('a[id^=action-form-dossier_instruction][id$=-rapport_instruction]').each(function(){
        $(this).bind_action_for_overlay("rapport_instruction");
    });
    // Bind actions rapport d'instruction depuis sous-dossier
    $('a[id^=action-form-sous_dossier][id$=-rapport_instruction]').each(function(){
        $(this).bind_action_for_overlay("rapport_instruction");
    });
    // Bind actions geolocalisation depuis dossier instruction
    $('a[id^=action-form-dossier_instruction][id$=-geolocalisation]').each(function(){
        $(this).bind_action_for_overlay("geolocalisation_sig");
    });
    // Bind actions geolocalisation depuis dossier contentieux
    $('a[id^=action-form-dossier_contentieux][id$=-geolocalisation]').each(function(){
        $(this).bind_action_for_overlay("geolocalisation_sig");
    });
    // Bind actions geolocalisation depuis sous-dossier
    $('a[id^=action-form-sous_dossier][id$=-geolocalisation]').each(function(){
        $(this).bind_action_for_overlay("geolocalisation_sig");
    });
    // Bind actions designation operateur depuis sous_dossier
    $('a[id^=action-form-dossier_instruction][id$=-designation_operateur]').each(function(){
        $(this).bind_action_for_overlay("dossier_operateur", "90%", modal_height, '', '', modal_position);
    });
    // Bind actions designation operateur depuis sous_dossier
    $('a[id^=action-form-sous_dossier][id$=-designation_operateur]').each(function(){
        $(this).bind_action_for_overlay("dossier_operateur", "90%", modal_height, '', '', modal_position);
    });
    // Bind actions geolocalisation depuis demande_avis
    $('#action-sousform-demande_avis_encours-rendre_avis').each(function(){
        $(this).bind_action_for_overlay("demande_avis_encours", "auto", "auto", returnToTab, 'demande_avis_encours');
    });
    // Bind actions prévisualisation document depuis document_numerise
    var modal_height = screen.availHeight * 0.90;
    var modal_position = { my: "left top", at: "top", of: window };
    $('a[id^=action-form-document_numerise][id$=-preview_edition]').each(function(){
        $(this).bind_action_for_overlay("document_numerise_preview_edition", "50%", modal_height, '', '', modal_position, false);
        // Récupération et affichage des miniatures lors du passage du curseur au dessus
        // de l'icône de prévisualisation et uniquement si l'option d'affichage des miniature
        // est active (visible via la classe tooltip)
        if ($(this).attr('class') == 'action action-self tooltip') {
            $(this).on('hover', function(){
                if ($(this).find('img').attr('class') != 'thumbnailLoaded') {
                    var idDossier = $(this).attr('id-dossier');
                    var img_src = '';
                    var objet = this;
                    $.ajax({
                        type: "GET",
                        url: "../app/index.php?module=form&obj=document_numerise&action=997&idx="+idDossier,
                        data: "html",
                        success: function(json){
                            img_src = json;
                            $(objet).find('img').attr('class', 'thumbnailLoaded');
                            $(objet).find('img').attr('src', img_src);
                        }
                    });
                }
            });
        }
    });
    // Bind actions prévisualisation document numerise depuis le sous onglet document
    $('a[id^=action-soustab-document_numerise-left-previsualiser]').each(function(){
        $(this).bind_action_for_overlay("document_numerise_preview_edition", "70%", modal_height, '', '', modal_position);
    });
    // Bind actions prévisualisation document de travail depuis le sous onglet document
    $('div#sousform-document_travail a[id^=action-soustab-document_numerise-left-previsualiser]').each(function(){
        $(this).bind_action_for_overlay("document_numerise_preview_edition", "70%", modal_height, '', '', modal_position);
    });
    // Bind actions prévisualisation instruction depuis document_numerise
    var modal_height = screen.availHeight * 0.90;
    var modal_position = { my: "left top", at: "top", of: window };
    $('a[id^=action-form-instruction][id$=-preview_edition]').each(function(){
        $(this).bind_action_for_overlay("instruction_preview_edition", "70%", modal_height, '', '', modal_position);
    });
    // Bind actions prévisualisation document d'instruction depuis le sous onglet document
    $('a[id^=action-soustab-document_instruction-left-previsualiser]').each(function(){
        $(this).bind_action_for_overlay("instruction_preview_edition", "70%", modal_height, '', '', modal_position);
    });
    // Bind actions prévisualisation rapport instruction depuis document_numerise
    var modal_height = screen.availHeight * 0.90;
    var modal_position = { my: "left top", at: "top", of: window };
    $('a[id^=action-form-rapport_instruction][id$=-preview_edition]').each(function(){
        $(this).bind_action_for_overlay("rapport_instruction_preview_edition", "70%", modal_height, '', '', modal_position);
    });
    // Bind actions prévisualisation rapport instruction historisé depuis document_numerise
    var modal_height = screen.availHeight * 0.90;
    var modal_position = { my: "left top", at: "top", of: window };
    $('a[id^=action-form-storage][id$=-preview_edition]').each(function(){
        $(this).bind_action_for_overlay("storage_preview_edition", "70%", modal_height, '', '', modal_position);
    });
    // Bind actions prévisualisation document consultation depuis document_numerise
    var modal_height = screen.availHeight * 0.90;
    var modal_position = { my: "left top", at: "top", of: window };
    $('a[id^=action-form-consultation][id$=-preview_edition]').each(function(){
        $(this).bind_action_for_overlay("consultation_preview_edition", "70%", modal_height, '', '', modal_position);
    });
    // Bind actions "normaliser l'adresse" depuis dossier instruction
    $('a[id^=action-form-dossier_instruction][id$=-normalize_address]').each(function(){
        $(this).bind_action_for_overlay("normalize_address", 'auto', 'auto', '', '', '', false);
    });
    // Bind actions "normaliser l'adresse" depuis dossier contentieux
    $('a[id^=action-form-dossier_contentieux][id$=-normalize_address]').each(function(){
        $(this).bind_action_for_overlay("normalize_address");
    });
    // Bind actions "normaliser l'adresse" depuis sous_dossier
    $('a[id^=action-form-sous_dossier][id$=-normalize_address]').each(function(){
        $(this).bind_action_for_overlay("normalize_address");
    });
    // Ajout de l'entete du tableau de l'onglet pièce -> document -> document d'instruction
    if (! $('#sousform-document_instruction .tab-tab .categorie').exists()) {
        $('#sousform-document_instruction .tab-tab thead').prepend(
                "\n<tr class=\"ui-tabs-nav ui-accordion ui-state-default tab-title\">\n"
                +"\t<th class=\"title categorie\" colspan=\"5\">Documents d'instruction</td>"
                +"</tr>\n"
        );
    }
    // Ajout de l'entete du tableau de l'onglet pièce -> document -> document de travail
    if (! $('#sousform-document_travail .tab-tab .categorie').exists()) {
        $('#sousform-document_travail .tab-tab thead').prepend(
                "\n<tr class=\"ui-tabs-nav ui-accordion ui-state-default tab-title\">\n"
                +"\t<th class=\"title categorie\" colspan=\"3\">Documents de travail</td>"
                +"</tr>\n"
        );
    }
    // Bind actions remplacer document signé depuis instruction
    $('#action-sousform-instruction-modale_selection_document_signe').each(function(){
        $(this).bind_action_for_overlay("instruction_modale");
    });

    // Permet d'afficher un autre texte sur l'action "Consulter" des dossiers d'instruction dématérialisés
    if ($('table.tab-tab tr.tab-data.consult-demat td.icons a span').exists()) {
        text_trad = '';
        $.ajax({
            type: "GET",
            url: "../app/index.php?module=form&obj=dossier_instruction&action=230&idx=0",
            cache: false,
            async: false,
            dataType: "json",
            success: function(json){
                if ('consulter' in json) {
                    text_trad = json['consulter'];
                }
            }
        });
        $('table.tab-tab tr.tab-data.consult-demat td.icons a span').each(function(){
            $(this).attr('title', text_trad);
        });
    }
 }

// Document is ready
$(initBindFocus);


/**
 * Si mode = server_side alors 
 * Renvoi sur om_widget.class.php::init_class_actions()
 * Le DOM est construit dans la méthode view_widget_rss() de la classe om_widget
 *
 * Si mode = client_side alors 
 * Le DOM est construit dans cette méthode Javascript
 *
 * @return void
 **/
function bind_widget_rss() {
    $(".widget_rss").each(function() {
        var bloc_html_cible = this.id;
        var mode = $("#"+bloc_html_cible+" .widget-rss-marker").data('mode');
        var id_widget = $("#"+bloc_html_cible+" .widget-rss-marker").data('id_widget');

        if (mode == 'server_side') { 
            $.ajax({
                type: "GET",
                url: "../app/index.php?module=form&obj=om_widget&action=4&idx="+id_widget,
                success: function(html){
                    $(html).appendTo($("#"+bloc_html_cible+" .widget-rss-marker"));
                }
            });
        }

        if (mode == 'client_side') {
            var link = $("#"+bloc_html_cible+" .widget-rss-marker").data('urls');
            var max_item = $("#"+bloc_html_cible+" .widget-rss-marker").data('max_item');
            var real_max_item = max_item - 1;
            var urls = link.split(",");
            var element = [];

            // Création d'une variable id_url pour rendre unique un url dans le
            // cas de multiple url sur le widget
            var id_url = 0;

            urls.forEach(function(url) {
                $.ajax(url).done(function(data) {
                var channel_title = data.getElementsByTagName('channel').item(0).getElementsByTagName('title').item(0).childNodes.item(0).nodeValue;

                element = {
                    "url" : url,
                    "channel_title" : channel_title,
                };

                id_url = id_url + 1;

                $("#"+bloc_html_cible+" .widget-rss-marker").append("<ul id='ul_"+id_url+"_"+bloc_html_cible+"'><h4>"+channel_title+"</h4>");

                    // Pour chaque item du flux
                    var x = data.getElementsByTagName('item');
                    if (x.length != 0) {
                        for (i=0; i<=real_max_item; i++) {
                            var item_title = x.item(i).getElementsByTagName('title').item(0).childNodes.item(0).nodeValue;  
                            var item_link = x.item(i).getElementsByTagName('link').item(0).childNodes.item(0).nodeValue;  
                            var item_desc = x.item(i).getElementsByTagName('description').item(0).childNodes.item(0).nodeValue;

                            element['items', i] = {
                                "title" : item_title,
                                "link" : item_link,
                                "description" : item_desc,
                            };

                            // Contenu
                            $("#ul_"+id_url+"_"+bloc_html_cible).append("<li><a href="+item_link+" target=_blank><h5>"+item_title+"</h5></a><p>"+item_desc+"</p></li>")
                        }
                    } else {
                        $("#ul_"+id_url+"_"+bloc_html_cible).append("Aucune donnée disponible")

                    }  
                });

            });
        }
    });
}


/**
 * Surcharge de la fonction ajaxIt spécifique au formulaire ouvert en
 * overlay ayant des actions directs.
 *
 * @param string objsf Objet ouvert en sous-formulaire
 * @param string link  Lien vers contenu à afficher
 *
 * @return void
 */
function overlayIt(objsf, link) {
    // execution de la requete en POST
    $.ajax({
        type: "GET",
        url: link,
        cache: false,
        success: function(html){
            $("#sousform-href").attr("id","sousform-href-disabled");
            $("#sousform-"+objsf).empty();
            $("#sousform-"+objsf).append(html);
            // Affiche la div necessaire aux actions directs
            var href = '<div id="sousform-href" ></div>'
            $("#sousform-"+objsf).append(href);
            if ($("#sousform-href").length) {
                $("#sousform-href").attr("data-href", link);
            }
            om_initialize_content(true);
            // Si on est dans l'overlay de gestion des operateurs
            if ($("#operateur_amenagement_pers_publique").exists() || $("#message_consultation_amenageur").exists()) {
                // Au chargement de l'overlay on appelle les fonctions permettant
                // d'afficher/cacher les champs d'opérateur
                switch_operateur_amenagement_pers_public($("#operateur_amenagement_pers_publique").val());
                if ($("#operateur_pers_publique_amenageur").exists()) {
                    switch_operateur_pers_publique_amenageur($("#operateur_pers_publique_amenageur").val());
                }
            }
        }
    });
}

/**
 * Fonction qui affiche ou cache des champs en fonction de la valeur
 * passée en paramètre
 * 
 * @param string undefined|'t'|'f' valeur du select operateur_amenagement_pers_public 
 * 
 * @return void
 */
function switch_operateur_amenagement_pers_public(field_select_value) {
    // On cache tous les champs
    $('#operateur_personne_publique').parent().parent().hide();
    $('#operateur_pers_publique_amenageur').parent().parent().hide();
    $('#operateur_personne_publique_avis').parent().parent().hide();
    $('#message_consultation_amenageur').parent().parent().hide();
    $('#message_consultation_tiers').parent().parent().hide();
    $('#fieldset-sousform-dossier_operateur-consultation-de-l_amenageur').hide();
    
    // Si la valeur n'est pas définie ou que la recherche d'opérateur 
    // n'a pas été lancé (opérateur inrap obligatoire)
    if (field_select_value == undefined
        || $('#operateur_detecte_inrap').val() == "") {
        return;
    }

    // Si le champ est à 'Oui'
    if (field_select_value == "t") {
        // On affiche le fieldset
        $('#fieldset-sousform-dossier_operateur-consultation-de-l_amenageur').show();
        $('#operateur_pers_publique_amenageur').parent().parent().show();
        // La valeur '' permet d'éviter un problème au chargement de l'overlay
        if ($('select#operateur_pers_publique_amenageur').val() == '') {
            // Enlève l'option '' du select qui doit compoter seulement Oui ou Non
            $('select#operateur_pers_publique_amenageur option[value=""]').prop('hidden', true);
            $('select#operateur_pers_publique_amenageur').val('t');
        }
        $("select#operateur_pers_publique_amenageur").change(function() {
                switch_operateur_pers_publique_amenageur($(this));
            });
        $('#message_consultation_amenageur').parent().parent().show();
        $('#operateur_personne_publique_avis').parent().parent().show();
    }

    if (field_select_value == "f") {
        $('#fieldset-sousform-dossier_operateur-consultation-de-l_amenageur').hide();
        $('#operateur_pers_publique_amenageur').parent().parent().hide();
        $('#operateur_pers_publique_amenageur').val('');
        $('#operateur_personne_publique').parent().parent().hide();
        $('#operateur_personne_publique').val('');
        $('#operateur_personne_publique_avis').parent().parent().hide();
        $('#operateur_personne_publique_avis').val('');
    }
}

/**
 * Fonction qui affiche ou cache des champs en fonction de la valeur
 * passée en paramètre
 * 
 * @param string undefined|'t'|'f' valeur du select operateur_pers_publique_amenageur 
 * 
 * @return void
 */
function switch_operateur_pers_publique_amenageur(field_select_value) {
    
    if (field_select_value == undefined) {
        return;
    }
    
    // Enlève l'option "" du select qui doit compoter seulement Oui ou Non
    $('select#operateur_pers_publique_amenageur option[value=""]').prop('hidden', true);

    if (field_select_value == "f") {
        $('#operateur_personne_publique').parent().parent().show();
        $('#message_consultation_tiers').parent().parent().show();
    }

    if (field_select_value == "t") {
        $('#operateur_personne_publique').parent().parent().hide();
        $('#operateur_personne_publique').val('');
        $('#message_consultation_tiers').parent().parent().hide();
    }
}


/**
 * ADVS_SEARCH - handle_highlight_advs_search.
 *
 * L'objectif ici est de mettre en valeur :
 *  - les champs sélectionnés une fois le formulaire validé
 *  - les champs en cours de modification avant validation du formulaire
 */
function handle_highlight_advs_search() {
    $("#adv-search-adv-fields select, #adv-search-adv-fields input").each(function() {
        if ($(this).val() != "") {
            $(this).addClass('advs-active-field-search');
        }
    });
    $("#adv-search-adv-fields select, #adv-search-adv-fields input").each(function() {
        $(this).change(function() {
            $(this).addClass('advs-unvalidate-field-search');
            $("#adv-search-submit").addClass('advs-unvalidate-field-search');
        });
    });
}


/**
 * ADVS_SEARCH - clear_form.
 *
 * Override framework_openmairie
 */
function clear_form(form) {
    if (form.selector == "#advanced-form") {
        $("#adv-search-adv-fields select, #adv-search-adv-fields input").each(function() {
            if ($(this).val() != "") {
                $(this).val('').trigger("change");
            }
        });
    } else {
        // On redéfinit la fonction du framework si on ne se trouve pas dans le contexte
        // de la recherche avancée.
        $(":input", 'form#'+form.attr('id'))
        .not(':button, :submit, :reset, :hidden')
        .val('')
        .removeAttr('checked')
        .removeAttr('selected');
    }
}



/**
 * WIDGET liés au formulaire et sousformulaire
 * 
 * Ces fonctions javascript sont appelées depuis les méthodes setOnChange,
 * setOnClick, ...
 */
//
// Cette fonction permet de retourner les informations sur le fichier téléchargé
// du formulaire d'upload vers le formulaire d'origine
function bible_return(form, champ) {
    // Initialisation de la variable contenant les valeurs sélectionnées
    var listeElement = '';
    // Récupération du contenu de chacun des éléments cochés
    $("span.content").each(function( index ) {
        if (document.getElementById('checkbox'+index).checked == true) {
            listeElement += $(this).attr('title').replace(/\r\n|\n|\r/g, '<br />')+'<br />';
        }
    });
    obj = tinyMCE.get(champ);
    // Remplissage du textarea et déclenchement du trigger autosize
    if(listeElement != '') {
        obj.setContent(obj.getContent()+"<br/>"+listeElement+"<br/>");
    }
    // Fermeture de la boite de dialog
    $('#upload-container').dialog('close').remove();
}
//
function bible(numero) {
    //
    var ev = document.f2.evenement.value;
    //
    if (ev == "") {
        window.alert("Vous devez d'abord sélectionner un événement.");
        return false;
    }
    //
    var idx = document.f2.dossier.value;
    //
    var link = "../app/index.php?module=form&obj=instruction&action=130&complement="+numero+"&ev="+ev+"&idx="+idx;
    load_form_in_modal(link);
    //
    return false;
}
// bible_auto - type httpclick
function bible_auto(){
    // Récupération de l'identifiant de l'événement
    var ev=document.f2.evenement.value;
    // Si pas d'événement on affiche un message d'erreur
    if (ev == "") {
        window.alert("Vous devez d'abord sélectionner un événement.");
        return false;
    }
    // Récupération de l'identifiant du dossier
    var idx=document.f2.dossier.value;
    // Récupération des retours de consultation et de la bible
    $.ajax({
        type: "GET",
        url: "../app/index.php?module=form&obj=instruction&action=140&idx="+idx+"&ev="+ev,
        cache: false,
        dataType: "json",
        success: function(data){
        
            // Remplissage du textarea complement_om_html
            if(data.complement_om_html != '') {
                var obj = tinyMCE.get('complement_om_html');
                obj.setContent(obj.getContent()+"<br/>"+data.complement_om_html+"<br/>");
            }
            // Remplissage du textarea complement2_om_html
            if(data.complement2_om_html != '') {
                var obj2 = tinyMCE.get('complement2_om_html');
                obj2.setContent(obj2.getContent()+"<br/>"+data.complement2_om_html+"<br/>");
            }
            // Remplissage du textarea complement2_om_html
            if(data.complement3_om_html != '') {
                var obj3 = tinyMCE.get('complement3_om_html');
                obj3.setContent(obj3.getContent()+"<br/>"+data.complement3_om_html+"<br/>");
            }
            // Remplissage du textarea complement4_om_html
            if(data.complement4_om_html != '') {
                var obj4 = tinyMCE.get('complement4_om_html');
                obj4.setContent(obj4.getContent()+"<br/>"+data.complement4_om_html+"<br/>");
            }
        }
    });

    return false;
}

// VerifNumdec - type text
function VerifNumdec(champ) {
    champ.value = champ.value.replace(",", "."); // remplacement de la virgule
    //if (champ.value.lastIndexOf(".") == -1){ // champ decimal
        if (isNaN(champ.value)) {
            alert(msg_alert_error_verifnum);
            champ.value = "";
            return;
        }
    //}
    
}

/**
 * Cette fonction permet de compléter le champ par des zéro par la gauche
 * @param  string  champ  Champ concerné
 * @param  integer length Taille du champ retourné
 */
function str_pad_js(champ, length) {

    // Initialisation de la variable str
    var str = '' + champ.value;

    // Si le champ n'est pas vide et que c'est un chiffre
    if (str != '' && /^[0-9]+$/.test(str) === true) {
        // Tant que la taille n'est pas atteint,
        // on ajoute des 0
        while (str.length < length) {
            str = '0' + str;
        }
        // Modifie le champ
        champ.value = str;
    }
}

// Ce widget permet de charger les données d'un select en ajax
function changeDataSelect(tableName, linkedField, joker){
    var id_dossierAutorisation = $("#dossier_autorisation").val();
    var id = $("#"+linkedField).val();
    link = "../app/listData.php?idx=" + id + "&tableName=" + tableName +
            "&linkedField=" + linkedField ;
    if(id_dossierAutorisation != "") {
        link += "&nature=EXIST";
    }
    var val_tableName = $('#'+tableName).val();
    $.ajax({
        type: "GET",
        url: link,
        cache: false,
        dataType: "json",
        success: function(html){
            
            $('#'+tableName).empty();
            var selected = "";
            if(val_tableName == "") {
                selected=' selected="selected"';
            }
            if ( joker == true )
                $('#'+tableName).append(
                    '<option value=""'+selected+'>*</option>'
                );
            else {
                $('#'+tableName).append(
                    '<option value=""'+selected+'>Choisir ' + tableName + '</option>'
                );
            }
            if ( html !== '' ){
                
                html = html.split(';');
                for ( i = 0 ; i < html.length - 1 ; i++ ){
                    
                    html_temp = html[i].split('_');
                    selected = "";
                    if(val_tableName == html_temp[0]) {
                        selected=' selected="selected"';
                    }
                    $('#'+tableName).append(
                        '<option value="'+html_temp[0]+'"'+selected+' >'+html_temp[1]+'</option>'
                    );
                    
                }
            }
        },
        async: false
    });
}

/**
 * Fonction de récupération des paramètres GET de la page
 * @return Array Tableau associatif contenant les paramètres GET
 */
function extractUrlParams(){    
    var t = location.search.substring(1).split('&');
    var f = [];
    for (var i=0; i<t.length; i++){
        var x = t[ i ].split('=');
        f[x[0]]=x[1];
    }
    return f;
}

// vuploadMulti - XXX
function vuploadMulti(champ) {
    //
    if (fenetreouverte == true) {
        pfenetre.close();
    }
    //
    pfenetre = window.open("../app/index.php?module=form&snippet=upload&origine="+champ+"&form="+$('input[name='+champ+']').closest('form').attr('name'),"upload","width=400,height=300,top=120,left=120");
    //
    fenetreouverte = true;
}

// Cette fonction permet de gérer la validation de l'action 
// affichage_reglementaire_registre de la classe demande
function affichage_reglementaire_registre(button) {
    // Popup de confirmation du traitement par l'utilisateur
    if (trt_confirm() == false) {
        return false;
    }
    // Suppression du bouton pour que l'utilisateur ne puisse pas cliquer une
    // deuxième fois
    $(button).remove();
    // Affichage du spinner
    $("#msg").html(msg_loading);
    // Requête AJAX vers le fichier l'action affichage_reglementaire_registre
    // pour mettre à jour les dossiers
    // XXX layout
    $.ajax({
        type: "GET",
        url: "../app/index.php?module=form&obj=demande_affichage_reglementaire_registre&action=110&idx=0&update",
        cache: false,
        success: function(html){
            // Ajout d'un bloc de message vide
            $('#msg').html(
                '<div class="message ui-widget ui-corner-all ui-state-highlight">'+
                    '<p>'+
                        '<span class="ui-icon ui-icon-info"></span>'+
                        '<span class="text">'+
                        '</span>'+
                    '</p>'+
                '</div>'
            );
            // Si le retour de l'appel Ajax n'est pas vide, alors il y a eu une
            // lors du traitement
            if ( html.length > 2 ) {
                $("#msg .message").addClass("ui-state-error");
                $("#msg .text").html(html);
            } else {
                // Sinon message de succès et appel de l'édition
                $("#msg .message").addClass("ui-state-valid");
                $("#msg .text").html("Traitement terminé. Le registre a été téléchargé.");
                window.open("../app/index.php?module=form&obj=demande_affichage_reglementaire_registre&action=111&idx=0");
            }
        },
        async: false
    });
    //
    return false;
}

/**
 * Copie modifiée des fonctions form_confirmation_action() et
 * form_execute_action_direct() afin de ne pas modifier les fonctions du 'core'
 * (framework openMairie).
 *
 * Fenêtre modale de confirmation spécifique à l'action de déclenchement du
 * traitement du registre d'affichage réglementaire.
 */
function registre_form_confirmation_action(elem, action, msg) {
    //
    $('#dialog-action-confirmation').remove();
    var dialogbloc = $("<div id=\"dialog-action-confirmation\">"+msg+"</div>").insertAfter('#footer');
    //
    $(dialogbloc).dialog( "destroy" );
    $(dialogbloc).dialog({
        resizable: false,
        height:180,
        width:350,
        modal: true,
        buttons: [
            {
                text: msg_form_action_confirmation_button_confirm,
                class: "ui-dialog-button-confirm",
                    click: function() {
                        $(this).dialog("close");
                        //
                        $('#'+elem+'-message').html(msg_loading);
                        // Suppression du bouton pour que l'utilisateur ne
                        // puisse pas cliquer une deuxième fois
                        $(action).remove();
                        //
                        $.ajax({
                            type: "POST",
                            url: $(action).attr('data-href')+"&validation=1&contentonly=true",
                            cache: false,
                            dataType: "html",
                            data: "submit=true",
                            success: function(html){
                                // XXX Il semble nécessaire afin de récupérer la portion de code
                                // div.message d'ajouter un container qui contient l'intégralité
                                // du code html représentant le contenu du formulaire. Si on ajoute
                                // pas ce bloc la récupération du bloc ne se fait pas.
                                container_specific_js = '<div id="container-specific-js">'+html+'</div>';
                                message = $(container_specific_js).find('div.message').get(0);
                                if (message == undefined) {
                                    message = -1;
                                }
                                // Ajout du contenu récupéré (uniquement le bloc message)
                                $('#'+elem+'-message').html(message);
                                // Rafraichissement du bloc de formulaire
                                form_container_refresh(elem);
                                // Initialisation JS du nouveau contenu de la page
                                om_initialize_content();
                            }
                        });
                    }
            }, {
                text: msg_form_action_confirmation_button_cancel,
                class: "ui-dialog-button-cancel",
                    click: function() {
                        $(this).dialog("close");
                    }
            }
        ]
    });
}

/**
 * WIDGET DASHBOARD - widget_recherche_dossier.
 *
 * Fonction de redirection pour le widget de recherche de dossier
 */
function widget_recherche_dossier(data, nbRes, obj) {
    // S'il n'y a qu'un seul résultat, afficher un résumé
    if (nbRes == 1) {
        window.location = "../app/index.php?module=form&obj=" + obj + "&action=3&" +
            "idx=" + data + "&premier=0&advs_id=&tricol=&" +
            "valide=&retour=tab";
    }
    // S'il y a une liste de dossier, redirection vers le tableau
    else {
        window.location = "../app/web_entry.php?obj=" + obj + "&field=dossier&value=" + data;
    }
}

/**
 * Retour spécifique de l'écran de consultation multiple - surcharge de ajaxIt
 * @todo XXX voir les différences avec ajaxIt et si il n'est pas possible
 * d'effectuer  la modification dans le core
 */
function messageIt(objsf, link, empty) {
    // execution de la requete en GET
    $.ajax({
        type: "GET",
        url: link,
        cache: false,
        success: function(html){
            (empty == true )?$("#sousform-"+objsf).empty():'';
            $("#sousform-"+objsf).append(html);
            om_initialize_content();
        },
        async: false
    });
}

/**
 * TTélécharegement de fichier pdf en ajax
 * spécifique de l'écran de consultation multiple 
 */
/* Plugin jQuery qui lance un espèce d'appel AJAX vers un script PHP de téléchargement de fichier*/
jQuery.download = function(url, data, method){
    //url and data options required
    if( url && data ){ 
        //data can be string of parameters or array/object
        data = typeof data == 'string' ? data : jQuery.param(data);
        //split params into form inputs
        var inputs = '';
        jQuery.each(data.split('&'), function(){ 
            var pair = this.split('=');
            inputs+='<input type="hidden" name="'+ pair[0] +'" value="'+ pair[1] +'" />'; 
        });
        //send request
        jQuery('<form action="'+ url +'" method="'+ (method||'post') +'">'+inputs+'</form>')
        .prependTo('body').submit().remove();
    };
};

/**
 * Cette fonction permet de charger dans un dialog jqueryui un formulaire tel
 * qu'il aurait été chargé avec ajaxIt
 * 
 * @param objsf string : objet de sousformulaire
 * @param link string : lien vers un sousformulaire
 * @param width integer: width en px
 * @param height integer: height en px
 * @param callback function (optionel) : nom de la méthode à appeler
 *                                       à la fermeture du dialog
 * @param callbackParams mixed (optionel) : paramètre à traiter dans la function
 *                                          callback 
 *
 **/
function popupIt(objsf, link, width, height, callback, callbackParams, position, resizable = true) {
    // Insertion du conteneur du dialog
    var dialog = $('<div id=\"sousform-'+objsf+'\"></div>').insertAfter('#tabs-1 .formControls-bottom');
    if( typeof(position) == 'undefined' ){
        position = 'left top';
    }
    // execution de la requete passee en parametre
    // (idem ajaxIt + callback)
    $.ajax({
        type: "GET",
        url: link,
        cache: false,
        success: function(html){
            //Suppression d'un precedent dialog
            dialog.empty();
            //Ajout du contenu recupere
            dialog.append(html);
            //Initialisation du theme OM
            om_initialize_content();
            //Creation du dialog
            $(dialog).dialog({
                //OnClose suppression du contenu
                close: function(ev, ui) {
                    // Si le formulaire est submit et valide on execute la méthode
                    // passée en paramètre
                    if (typeof(callback) === "function") {
                        callback(callbackParams);
                    }
                    $(this).remove();
                },
                resizable: resizable,
                modal: true,
                width: width,
                height: height,
                position: position,
            });
        },
        async : false
    });

    //Fermeture du dialog lors d'un clic sur le bouton retour
    $('#sousform-'+objsf).off("click").on("click",'a.retour',function() {
        $(dialog).dialog('close').remove();
        return false;
    });
}

/***
 * Fonction getter des paramètres de l'url courante
 */
// Parse URL Queries Method
(function($){
    $.getQuery = function( query ) {
        query = query.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
        var expr = "[\\?&]"+query+"=([^&#]*)";
        var regex = new RegExp( expr );
        var results = regex.exec( window.location.href );
        if( results !== null ) {
            return results[1];
        } else {
            return false;
        }
    };
})(jQuery);


/*
 * Javascript concernant la demande d'avis
 * 
 * 
 */

/**
 * Fonction de callback appelée lors de la fermeture du dialog (popupit)
 * du retour d'avis d'un service
 **/
function returnToTab(objsf) {
    var valid=$('#sousform-'+objsf+' div.ui-state-valid');
    if(valid.length > 0) {
        document.location.href="../app/index.php?module=tab&obj="+$.getQuery('obj')+"&premier="+$.getQuery('premier')
        +"&advs_id="+$.getQuery('advs_id')+"&tricol="+$.getQuery('tricol');
    }
};


/*
 * Javascript concernant la demande
 * 
 * 
 */

 /**
  * Fonction permettant de mettre à jour les infos du demandeur
  **/
function getDemandeurId(type) {
    var id_demandeur=$('#id_retour').val();
    if($.isNumeric(id_demandeur)) {
        afficherDemandeur(id_demandeur,type);
        om_initialize_content();
    }
}

/**
 * Fonction permettant d'afficher la synthèse d'un demandeur
 */
function afficherDemandeur(id,type) {
    $.ajax({
        type: "GET",
        url: '../app/afficher_synthese_demandeur.view.php?iddemandeur='+id+'&type='+type,
        cache: false,
        success: function(html){
            $(html).insertBefore('#add_'+type).fadeIn(500);

        },
        async:false
    });
    affichageBoutonsDemandeurs();
}

/**
 * Fonction permettant de modifier un demandeur
 */
function editDemandeur(obj,id,type,id_css) {
    id_dossier = '';

    if ($("#dossier").size() !== 0) {
        id_dossier=$("#dossier").val();
    }
    var url = '../app/index.php?module=sousform&obj='+obj+'&retourformulaire=demande&action=1&idx='+id+'&idx_dossier='+id_dossier;
    popupIt(obj, url, 860, 'auto',
            replaceDemandeur, {'type':type,'id': id, 'id_css':id_css});
    affichageBoutonsDemandeurs();
}

/**
 * Function permettant de remplacer un contenu déjà existant
 **/
function replaceDemandeur(obj) {
    var new_demandeur=$('#id_retour').val();
    if($.isNumeric(new_demandeur)) {
        $.ajax({
            type: "GET",
            url: '../app/afficher_synthese_demandeur.view.php?iddemandeur='+new_demandeur+'&type='+obj.type,
            cache: false,
            success: function(html){
                $(obj.id_css).replaceWith(html);
            }
        });
    }
}
/**
 * Function permettant de remplacer un contenu déjà existant
 **/
function removeDemandeur(id) {
    var div_class=$('#'+id).attr("class");
    $('#'+id).remove();
    if(div_class == "delegataire") {
        $('#add_delegataire').fadeIn(500);
    }
    if(div_class == "proprietaire") {
        $('#add_proprietaire').fadeIn(500);
    }
    if(div_class == "architecte_lc") {
        $('#add_architecte_lc').fadeIn(500);
    }
    if(div_class == "paysagiste") {
        $('#add_paysagiste').fadeIn(500);
    }
    affichageBoutonsDemandeurs();
}

/**
 * Fonction permettant d'afficher et cacher les boutons d'ajout de demandeurs
 */
function affichageBoutonsDemandeurs(){
    // Si le fieldset Demandeurs n'est pas présent, on sort de la fonction
    if($('#liste_demandeur').size() === 0) {
        return false;
    }
    // Affichage des blocs en fonction du type de demande
    type_aff_form = getDemandeInfo('type_aff_form');
    switch (type_aff_form) {
        case 'CONSULTATION ENTRANTE':
        case 'ADS':
            // Suppression des types de demandeurs d'autres type de DA
            $('.plaignant_principal').each(function() {
                $(this).remove();
            });
            $('.plaignant').each(function() {
                $(this).remove();
            });
            $('.contrevenant_principal').each(function() {
                $(this).remove();
            });
            $('.contrevenant').each(function() {
                $(this).remove();
            });
            $('.requerant').each(function() {
                $(this).remove();
            });
            $('.avocat').each(function() {
                $(this).remove();
            });
            $('.bailleur_principal').each(function() {
                $(this).remove();
            });
            $('.bailleur').each(function() {
                $(this).remove();
            });
            // Affichage ou non des blocs
            $('#plaignant_contrevenant').hide();
            $('#requerant_avocat').hide();
            $('#petitionnaire_principal_delegataire_bailleur').hide();
            $('#petitionnaire_principal_delegataire').fadeIn(500);
            break;
            
        case 'CTX RE':
            // Suppression des types de demandeurs d'autres type de DA
            $('.plaignant_principal').each(function() {
                $(this).remove();
            });
            $('.plaignant').each(function() {
                $(this).remove();
            });
            $('.contrevenant_principal').each(function() {
                $(this).remove();
            });
            $('.contrevenant').each(function() {
                $(this).remove();
            });
            $('.bailleur_principal').each(function() {
                $(this).remove();
            });
            $('.bailleur').each(function() {
                $(this).remove();
            });
            // Affichage ou non des blocs
            $('#plaignant_contrevenant').hide();
            $('#requerant_avocat').hide();
            $('#petitionnaire_principal_delegataire_bailleur').hide();
            $('#petitionnaire_principal_delegataire').fadeIn(500);
            // Affichage du bloc requerant/avocat
            if ($('input[name^=petitionnaire_principal]').size() > 0) {
                $('#requerant_avocat').fadeIn(500);
            } else {
                $('#requerant_avocat').hide();
            }
            break;
            
        case 'CTX IN':
            $('.petitionnaire_principal').each(function() {
                $(this).remove();
            });
            $('.delegataire').each(function() {
                $(this).remove();
            });
            $('.petitionnaire').each(function() {
                $(this).remove();
            });
            $('.requerant').each(function() {
                $(this).remove();
            });
            $('.avocat').each(function() {
                $(this).remove();
            });
            $('.bailleur_principal').each(function() {
                $(this).remove();
            });
            $('.bailleur').each(function() {
                $(this).remove();
            });
            $('#requerant_avocat').hide();
            $('#petitionnaire_principal_delegataire').hide(); 
            $('#listePetitionnaires').hide();
            $('#petitionnaire_principal_delegataire_bailleur').hide();
            $('#plaignant_contrevenant').fadeIn(500);
            $('#listeContrevenants').fadeIn(500);
            break;

        case 'DPC':
            // Suppression des types de demandeurs d'autres type de DA
            $('.plaignant_principal').each(function() {
                $(this).remove();
            });
            $('.plaignant').each(function() {
                $(this).remove();
            });
            $('.contrevenant_principal').each(function() {
                $(this).remove();
            });
            $('.contrevenant').each(function() {
                $(this).remove();
            });
            $('.requerant').each(function() {
                $(this).remove();
            });
            $('.avocat').each(function() {
                $(this).remove();
            });
            // Affichage ou non des blocs
            $('#plaignant_contrevenant').hide();
            $('#requerant_avocat').hide();
            $('#petitionnaire_principal_delegataire').fadeIn(500);
            $('#petitionnaire_principal_delegataire_bailleur').fadeIn(500);
            $('#listeBailleurs').fadeIn(500);
            break;
        default:
            
    }

    // Si formulaire après validation on cache les boutons d'ajout de demandeurs
    url = document.location + "" ;
    if ($('#liste_demandeur').size() > 0
        && $("form[name=f1] .form-is-valid").size() > 0 ) {

        $('#add_petitionnaire_principal').hide();
        $('#add_delegataire').hide();
        if($('input[name=delegataire][type=hidden]').size() == 0) {
            $('#delegataire').hide();
        }
        $('#add_petitionnaire').hide();
        $('#add_plaignant').hide();
        $('#add_contrevenant_principal').hide();
        $('#add_contrevenant').hide();
        if($('input[name=contrevenant][type=hidden]').size() == 0) {
            $('#contrevenant').hide();
        }
        $('#add_requerant').hide();
        $('#add_avocat').hide();
        $('#add_bailleur_principal').hide();
        $('#add_bailleur').hide();
        if($('input[name=bailleur][type=hidden]').size() == 0) {
            $('#bailleur').hide();
        }
        $('#add_proprietaire').hide();
        $('#add_architecte_lc').hide();
        $('#add_paysagiste').hide();

    } else if ($('form[name=f1] #liste_demandeur').size() > 0) {
        // Affichage du bouton d'ajout du petitionnaire principal
        if($('input[name^=petitionnaire_principal]').size() > 0) {
            $('#add_petitionnaire_principal').hide();
        } else {
            $('#add_petitionnaire_principal').fadeIn(500);
        }
        // Affichage du bloc delegataire
        if($('input[name^=petitionnaire_principal]').size() == 0) {
            $('#delegataire').hide();
        } else {
            $('#delegataire').fadeIn(500);
        }
        // Affichage du bouton délégataire
        if($('input[name^=petitionnaire_principal]').size() == 0 ||
            $('input[name^=delegataire]').size() > 0) {
            $('#add_delegataire').hide();
        } else {
            $('#add_delegataire').fadeIn(500);
        }
        // Affichage du bloc proprietaire
        if($('input[name^=petitionnaire_principal]').size() == 0) {
            $('#proprietaire').hide();
        } else {
            $('#proprietaire').fadeIn(500);
        }
        // Affichage du bouton proprietaire
        if($('input[name^=petitionnaire_principal]').size() == 0 ||
            $('input[name^=proprietaire]').size() > 0) {
            $('#add_proprietaire').hide();
        } else {
            $('#add_proprietaire').fadeIn(500);
        }
        // Affichage du bloc architecte_lc
        if($('input[name^=petitionnaire_principal]').size() == 0) {
            $('#architecte_lc').hide();
        } else {
            $('#architecte_lc').fadeIn(500);
        }
        // Affichage du bouton architecte_lc
        if($('input[name^=petitionnaire_principal]').size() == 0 ||
            $('input[name^=architecte_lc]').size() > 0) {
            $('#add_architecte_lc').hide();
        } else {
            $('#add_architecte_lc').fadeIn(500);
        }
        // Affichage du bloc paysagiste
        if($('input[name^=petitionnaire_principal]').size() == 0) {
            $('#paysagiste').hide();
        } else {
            $('#paysagiste').fadeIn(500);
        }
        // Affichage du bouton paysagiste
        if($('input[name^=petitionnaire_principal]').size() == 0 ||
            $('input[name^=paysagiste]').size() > 0) {
            $('#add_paysagiste').hide();
        } else {
            $('#add_paysagiste').fadeIn(500);
        }
        // Affichage du bloc petitionnaire
        if($('input[name^=petitionnaire_principal]').size() == 0) {
            $('#listePetitionnaires').hide();
        } else {
            $('#listePetitionnaires').fadeIn(500);
        }
        // Affichage du bouton petitionnaire
        if($('input[name^=petitionnaire_principal]').size() == 0) {
            $('#add_petitionnaire').hide();
        } else {
            $('#add_petitionnaire').fadeIn(500);
        }
        // Affichage du bloc petitionnaire
        if($('input[name^=petitionnaire_principal]').size() == 0) {
            $('#listePetitionnaires').hide();
        } else {
            $('#listePetitionnaires').fadeIn(500);
        }
        if($('input[name^=requerant_principal]').size() == 0) {
            $('#listeAutresRequerants').hide();
        } else {
            $('#listeAutresRequerants').fadeIn(500);
        }
        if($('input[name^=avocat_principal]').size() == 0) {
            $('#listeAutresAvocats').hide();
        } else {
            $('#listeAutresAvocats').fadeIn(500);
        }

        if ($('input[name^=petitionnaire_principal]').size() == 0 ||
            $('input[name^=requerant_principal]').size() > 0) {
            $('#add_requerant_principal').hide();
            $('#add_requerant').fadeIn(500);
        } else {
            $('#add_requerant_principal').fadeIn(500);
            $('#add_requerant').hide();
        }
        
        if ($('input[name^=petitionnaire_principal]').size() == 0 ||
            $('input[name^=avocat_principal]').size() > 0) {
            $('#add_avocat_principal').hide();
            $('#add_avocat').fadeIn(500);
        } else {
            $('#add_avocat_principal').fadeIn(500);
            $('#add_avocat').hide();
        }

        // Formulaire CTX IN
        // Affichage du bouton d'ajout du contrevenant principal
        if($('input[name^=contrevenant_principal]').size() > 0) {
            $('#add_contrevenant_principal').hide();
        } else {
            $('#add_contrevenant_principal').fadeIn(500);
        }
        // Affichage du bouton contrevenant
        if($('input[name^=contrevenant_principal]').size() == 0) {
            $('#listeAutresContrevenants').hide();
            $('#add_contrevenant').hide();
        } else {
            $('#listeAutresContrevenants').fadeIn(500);
            $('#add_contrevenant').fadeIn(500);
        }
        // Affichage du bloc Plaignants
        if($('input[name^=contrevenant_principal]').size() == 0) {
            $('#listePlaignants').hide();
        } else {
            $('#listePlaignants').fadeIn(500);
        }
        if($('input[name^=plaignant_principal]').size() == 0) {
            $('#listeAutresPlaignants').hide();
        } else {
            $('#listeAutresPlaignants').fadeIn(500);
        }
        if ($('input[name^=contrevenant_principal]').size() == 0 ||
            $('input[name^=plaignant_principal]').size() > 0) {
            $('#add_plaignant_principal').hide();
            $('#add_plaignant').fadeIn(500);
        } else {
            $('#add_plaignant_principal').fadeIn(500);
            $('#add_plaignant').hide();
        }

        // Formulaire DPC
        if($('input[name^=bailleur_principal]').size() > 0) {
            $('#add_bailleur_principal').hide();
        } else {
            $('#add_bailleur_principal').fadeIn(500);
        }
        if($('input[name^=bailleur_principal]').size() == 0) {
            $('#listeAutresBailleurs').hide();
            $('#add_bailleur').hide();
        } else {
            $('#listeAutresBailleurs').fadeIn(500);
            $('#add_bailleur').fadeIn(500);
        }
    }
}

/**
 * Appel au chargement de la page
 **/
$(function() {
    /**
     * Gère la mise en valeur des champs modifiés ou validés de la recherche avancée.
     */
    handle_highlight_advs_search();
    
    if ( $('#type_demandeur') == 'petitionnaire' || 
        $('#type_demandeur') == 'avocat' || 
        $('#type_demandeur') == 'bailleur'){
        addSearchIcon();
        addDivDialog('.bloc_demandeur');
    }
    affichageBoutonsDemandeurs();
    id_dossier = '';

    if ($("#dossier").size() !== 0) {
        id_dossier=$("#dossier").val();
    }
    // Bind de la fonction permettant l'ajout du pétitionnaire principal
    $("#formulaire").on("click","#add_petitionnaire_principal",  function() {
        popupIt('petitionnaire',
                '../app/index.php?module=sousform&obj=petitionnaire&action=0'+
                '&retourformulaire=demande&principal=true&idx_dossier='+id_dossier, 860, 'auto',
                getDemandeurId, 'petitionnaire_principal');
    });
    // Bind de la fonction permettant l'ajout du plaignant
    $("#formulaire").on("click","#add_plaignant_principal",  function() {
        popupIt('plaignant',
                '../app/index.php?module=sousform&obj=plaignant&action=0'+
                '&retourformulaire=demande&idx_dossier='+id_dossier, 860, 'auto',
                getDemandeurId, 'plaignant_principal');
    });
    // Bind de la fonction permettant l'ajout du plaignant
    $("#formulaire").on("click","#add_plaignant",  function() {
        popupIt('plaignant',
                '../app/index.php?module=sousform&obj=plaignant&action=0'+
                '&retourformulaire=demande&idx_dossier='+id_dossier, 860, 'auto',
                getDemandeurId, 'plaignant');
    });
    // Bind de la fonction permettant l'ajout du contrevenant principal
    $("#formulaire").on("click","#add_contrevenant_principal",  function() {
        popupIt('contrevenant',
                '../app/index.php?module=sousform&obj=contrevenant&action=0'+
                '&retourformulaire=demande&idx_dossier='+id_dossier, 860, 'auto',
                getDemandeurId, 'contrevenant_principal');
    });
    // Bind de la fonction permettant l'ajout du contrevenant
    $("#formulaire").on("click","#add_contrevenant",  function() {
        popupIt('contrevenant',
                '../app/index.php?module=sousform&obj=contrevenant&action=0'+
                '&retourformulaire=demande&idx_dossier='+id_dossier, 860, 'auto',
                getDemandeurId, 'contrevenant');
    });
    // Bind de la fonction permettant l'ajout du requerant
    $("#formulaire").on("click","#add_requerant_principal",  function() {
        popupIt('requerant',
                '../app/index.php?module=sousform&obj=requerant&action=0'+
                '&retourformulaire=demande&idx_dossier='+id_dossier, 860, 'auto',
                getDemandeurId, 'requerant_principal');
    });
    // Bind de la fonction permettant l'ajout du requerant
    $("#formulaire").on("click","#add_requerant",  function() {
        popupIt('requerant',
                '../app/index.php?module=sousform&obj=requerant&action=0'+
                '&retourformulaire=demande&idx_dossier='+id_dossier, 860, 'auto',
                getDemandeurId, 'requerant');
    });
    // Bind de la fonction permettant l'ajout de l'avocat
    $("#formulaire").on("click","#add_avocat_principal",  function() {
        popupIt('avocat',
                '../app/index.php?module=sousform&obj=avocat&action=0'+
                '&retourformulaire=demande&idx_dossier='+id_dossier, 860, 'auto',
                getDemandeurId, 'avocat_principal');
    });
    // Bind de la fonction permettant l'ajout de l'avocat
    $("#formulaire").on("click","#add_avocat",  function() {
        popupIt('avocat',
                '../app/index.php?module=sousform&obj=avocat&action=0'+
                '&retourformulaire=demande&idx_dossier='+id_dossier, 860, 'auto',
                getDemandeurId, 'avocat');
    });
    // Bind de la fonction permettant l'ajout du délégataire
    $("#formulaire").on("click","#add_delegataire", function(event) {
        popupIt('delegataire',
                '../app/index.php?module=sousform&obj=delegataire&action=0'+
                '&retourformulaire=demande&idx_dossier='+id_dossier, 860, 'auto',
                getDemandeurId, 'delegataire');
    });
    // Bind de la fonction permettant l'ajout des pétitionnaires
    $("#formulaire").on("click","#add_petitionnaire", function(event) {
        popupIt('petitionnaire',
                '../app/index.php?module=sousform&obj=petitionnaire&action=0'+
                '&retourformulaire=demande&idx_dossier='+id_dossier, 860, 'auto',
                getDemandeurId, 'petitionnaire');
    });
    // Bind de la fonction permettant l'ajout du bailleur principal
    $("#formulaire").on("click","#add_bailleur_principal",  function() {
        popupIt('bailleur',
                '../app/index.php?module=sousform&obj=bailleur&action=0'+
                '&retourformulaire=demande&idx_dossier='+id_dossier, 860, 'auto',
                getDemandeurId, 'bailleur_principal');
    });
    // Bind de la fonction permettant l'ajout des bailleurs
    $("#formulaire").on("click","#add_bailleur",  function() {
        popupIt('bailleur',
                '../app/index.php?module=sousform&obj=bailleur&action=0'+
                '&retourformulaire=demande&idx_dossier='+id_dossier, 860, 'auto',
                getDemandeurId, 'bailleur');
    });
    // Bind de la fonction permettant l'ajout du délégataire
    $("#formulaire").on("click","#add_proprietaire", function(event) {
        popupIt('proprietaire',
                '../app/index.php?module=sousform&obj=proprietaire&action=0'+
                '&retourformulaire=demande&idx_dossier='+id_dossier, 860, 'auto',
                getDemandeurId, 'proprietaire');
    });
    // Bind de la fonction permettant l'ajout de l'architecte_lc
    $("#formulaire").on("click","#add_architecte_lc", function(event) {
        popupIt('architecte_lc',
                '../app/index.php?module=sousform&obj=architecte_lc&action=0'+
                '&retourformulaire=demande&idx_dossier='+id_dossier, 860, 'auto',
                getDemandeurId, 'architecte_lc');
    });
    // Bind de la fonction permettant l'ajout du paysagiste
    $("#formulaire").on("click","#add_paysagiste", function(event) {
        popupIt('paysagiste',
                '../app/index.php?module=sousform&obj=paysagiste&action=0'+
                '&retourformulaire=demande&idx_dossier='+id_dossier, 860, 'auto',
                getDemandeurId, 'paysagiste');
    });

    url = document.location + "" ;
    if (url.indexOf("index.php?module=form&") != -1 &&
        (
        url.indexOf("obj=demande&") != -1 ||
        url.indexOf("obj=dossier&") != -1 ||
        url.indexOf("obj=dossier_instruction&") != -1 ||
        url.indexOf("obj=dossier_instruction_mes_encours&") != -1 ||
        url.indexOf("obj=dossier_instruction_tous_encours&") != -1 ||
        url.indexOf("obj=dossier_instruction_mes_clotures&") != -1 ||
        url.indexOf("obj=dossier_instruction_tous_clotures&") != -1 ||
        url.indexOf("obj=dossier_contentieux_mes_infractions&") != -1 ||
        url.indexOf("obj=dossier_contentieux_toutes_infractions&") != -1 ||
        url.indexOf("obj=dossier_contentieux_mes_recours&") != -1 ||
        url.indexOf("obj=dossier_contentieux_tous_recours&") != -1 ||
        url.indexOf("obj=sous_dossier&") != -1
        )
        && url.indexOf("&action=3") == -1
        && url.indexOf("&action=126") == -1
        && url.indexOf("&action=2") == -1
        && url.indexOf("&action=160") == -1) {

        formatFieldReferenceCadastrale();
    }

    // S'il y a une erreur durant la validation lors de l'ajout
    // d'une nouvelle demande
    if (url.indexOf("index.php?module=form") != -1 &&
        (url.indexOf("obj=demande_nouveau_dossier&") != -1
        || url.indexOf("obj=demande_nouveau_dossier_contentieux&") != -1)
        && (url.indexOf("&action=3") == -1
        && url.indexOf("&action=2") == -1
        && url.indexOf("&validation") != -1
        && $(".form-is-valid").size() == 0)) {

        addButtonCadastraleAdesse();
        formatFieldReferenceCadastrale();
        manage_display_demande($('#dossier_autorisation_type_detaille').val());
        //On affiche le select du type de la demande
        if ($('#demande_type option').size() > 2) {
            $('#demande_type').parent().parent().show();
        }
        // if ($("#formulaire div.bloc_numero_complet_dossier div.bloc_activ_num_manu input#num_doss_manuel")[0].check === true) {
            verifier_numerotation_urbanisme($('#num_doss_complet'));
        // }
    }

    if (url.indexOf("index.php?module=form") != -1
        && (url.indexOf("obj=demande_nouveau_dossier&") != -1
        || url.indexOf("obj=demande_nouveau_dossier_contentieux&") != -1)
        && (url.indexOf("&action=3") == -1
        && url.indexOf("&action=2") == -1
        && url.indexOf("&validation") == -1
        && $(".form-is-valid").size() == 0)) {
        
        addButtonCadastraleAdesse();
        changeDemandeType();
    }
    
    // Ajout de demande
    if (url.indexOf("index.php?module=form") != -1
        && (url.indexOf("obj=demande_nouveau_dossier&") != -1
        || url.indexOf("obj=demande_nouveau_dossier_contentieux&") != -1
        || url.indexOf("obj=demande_dossier_encours&") != -1
        || url.indexOf("obj=demande_autre_dossier&") != -1)
        && url.indexOf("&action=0") != -1
        && url.indexOf("&validation") == -1){

        /*Cache les champs avant que dossier_autorisation_type_detaille soit choisi*/
        hideFields();
    }
    
    // Ajout de demande sur dossier existant
    if (url.indexOf("index.php?module=form") != -1
        && (url.indexOf("obj=demande_dossier_encours&") != -1
        || url.indexOf("obj=demande_autre_dossier&") != -1)
        && url.indexOf("&action=0") != -1
        && url.indexOf("&validation") == -1){

        //Cache les champs avant que dossier_autorisation_type_detaille soit choisi
        hideFields();
        //On affiche le select du type de la demande
        $('#demande_type').parent().parent().show();
    }
    
    // Modification de demande
    if ( url.indexOf("index.php?module=form") != -1
         && (
            url.indexOf("obj=demande&") != -1
            || url.indexOf("obj=demande_nouveau_dossier&") != -1
            || url.indexOf("obj=demande_nouveau_dossier_contentieux&") != -1
            || url.indexOf("obj=demande_dossier_encours&") != -1
            || url.indexOf("obj=demande_autre_dossier&") != -1
        )
        && url.indexOf("&action") == -1 
    ){

        formatFieldReferenceCadastrale();
    }

    // Sur le formulaire d'ajout d'une nouvelle demande au chargement de la page
    // Si l'option pour saisir la nuérotation manuelle est activée
    if ($("#formulaire div.bloc_numero_dossier").exists() === true) {
        // Affiche ou cache le bloc de la numérotation manuelle en fonction de
        // la case à cocher
        toggle_num_dossier_manuel($("#formulaire div.bloc_numero_dossier div.bloc_activ_num_manu input#num_doss_manuel")[0], true);
    }

    // Sur le formulaire d'ajout d'une nouvelle demande au chargement de la page
    // Si l'option pour saisir la nuérotation manuelle est activée
    if ($("#formulaire div.bloc_numero_complet_dossier").exists() === true) {
        // Affiche ou cache le bloc de la numérotation manuelle en fonction de
        // la case à cocher
        toggle_num_dossier_manuel_complet($("#formulaire div.bloc_numero_complet_dossier div.bloc_activ_num_manu input#num_doss_manuel")[0], true);
    }

    if (url.indexOf("index.php?module=form&") != -1
        && url.indexOf("obj=commission&") != -1
        && (url.indexOf("&action=0") != -1
        || url.indexOf("&action=1") != -1)
        && url.indexOf("&validation") == -1
        && $(".form-is-valid").size() == 0) {
        changeCommissionType();    
    }

    // surcharge la fonction de sélection des onglets
    // pour déclencher le (re)chargement de l'onglet DI
    // à chaque futur clic provenant d'un autre onglet
    var tabs_select_function = $("#formulaire").tabs('option', 'select');
    $("#formulaire").tabs('option', 'select', function(event, ui) {
        var clicked_on_di_from_another_tab = set_di_href_in_data_load_tabs(event, ui);
        tabs_select_function(event, ui);
        // cache la recherche dynamique si clique sur DI
        if (clicked_on_di_from_another_tab) {
            $('#recherche_onglet').hide();
        }
    });

    // Si on est dans le listing du widget suivi_tache on
    // ajoute une infobulle sur la colonne du type de tache.
    if (url.indexOf("index.php?module=tab&") != -1
            && url.indexOf("obj=suivi_tache&") != -1) {

        // On doit récupérer la valeur du paramètre widget_recherche_id pour la requête ajax
        urlParams = extractUrlParams();
        typeTitleText = '';
        // Requête ajax de récupération des données
        $.ajax({
            type: "GET",
            url: "../app/index.php?module=form&obj=suivi_tache&action=998&idx=0&widget_recherche_id="+urlParams['widget_recherche_id'],
            async: false,
            success: function(data){
                typeTitleText = data;
            }
        });
        //
        $('<span id="infobulle-type" class="ui-icon ui-icon-info" title="'+typeTitleText+'"></span>').insertAfter($("th.col-3 > span.ui-icon-search"));
    }
});

/*
 * Action sur les champs pour les références cadastrales
 */
function formatFieldReferenceCadastrale(){

    addNewFieldReferencesCadastrales();
    $('#terrain_references_cadastrales').parent().parent().hide();
    
    url = document.location + "";

    reference_cadastrale = $('#terrain_references_cadastrales').val();
    /*Formatage de la reference cadastrale*/
    if ( reference_cadastrale != '' ){
        
        /* Récupère la référence cadastrale non formatée */
        references_cadastrales = reference_cadastrale.split(';');
        donnees = new Array();
        
        i = 0 ;
        /* Boucle sur les références, elles étaient séparées par un ; */
        for ( idx_line = 0 ; idx_line < references_cadastrales.length - 1 ; idx_line ++ ) {
            
            /*Récupère le code impôts du quartier [CHIFFRES]*/
            k = 0;
            donnees[i] = '';
            for ( j = k ; j < references_cadastrales[idx_line].length ; j++ ) {
                
                if ( k <= 2 ) {
                        
                    donnees[i] += references_cadastrales[idx_line].charAt(j);
                    k++;
                    
                } else {
                    
                    i++;
                    break;
                }
            }

            var only_one_letter = true;

            // Le dernier chiffre de la parcelle est soit au caractère 9 soit au caractère 8
            if (references_cadastrales[idx_line].charAt(8).length == 0
                || references_cadastrales[idx_line].charAt(8) == "A" || references_cadastrales[idx_line].charAt(8) == "/" ) {

                only_one_letter = true;

            } else if ( /^[0-9]+$/.test(references_cadastrales[idx_line].charAt(8)) === true ) { 
            
                only_one_letter = false;
            }

            /* Récupère la section [LETTRES / CHIFFRES] */     
            donnees[i] = '';
            for ( j = k ; j < references_cadastrales[idx_line].length ; j++ )
                if ( (k == 3 || k == 4) && only_one_letter === false
                     || k == 3 && only_one_letter === true) {
                    
                    donnees[i] += references_cadastrales[idx_line].charAt(j);
                    k++;
                    
                } else {
                    
                    i++;
                    break;
                }
            
            /* Récupère la parcelle [CHIFFRES] */
            donnees[i] = '';
            for ( j = k ; j < references_cadastrales[idx_line].length ; j++ )
                if ( (k>=5 && k<9) && only_one_letter === false
                    || (k>=4 && k<8) && only_one_letter === true){
                        
                    donnees[i] += references_cadastrales[idx_line].charAt(j);
                    k++;
                    
                } else {
                    
                    break;
                }
            
            /* Récupère les séparateurs [ A / ] */
            nb_suffixes = 0; // chaque paire de champs additionnels sur une ligne
            if ( k < references_cadastrales[idx_line].length ) {
                
                for ( j = k ; j < references_cadastrales[idx_line].length ; j++ )
                    if ( isAlpha(references_cadastrales[idx_line].charAt(j)) ){
                        
                        nb_suffixes++;
                        donnees[++i] = references_cadastrales[idx_line].charAt(j);
                        donnees[++i] = '';
                    }
                    else {
                        
                        donnees[i] += references_cadastrales[idx_line].charAt(j);
                    }
            }
            
            /*Créé autant de champs de que de référence */
            donnees[++i] = ';';
            i++;

            if ( idx_line > 0 ) {
                
                $('.reference_cadastrale_custom_fields').append( 
                    "<br/>" + fieldReferenceCadastraleBase()
                );
            }
            
            actionFormReferenceCadastrale();
            
            if ( nb_suffixes > 0 ) {
                        
                for ( j = 0 ; j < nb_suffixes ; j++ ){
                    
                    var idx_last_line = $('.moreFieldReferenceCadastrale').length - 1;
                    var selector = '#moreFieldReferenceCadastrale' + idx_last_line;
                    /*Boutton "ajouter d'autres champs" (le dernier à ce moment là de l'exécution)*/
                    var more_fields_button = $(selector);
                    if (more_fields_button.length === 0) {
                        console.error('Boutton "ajouter d\'autres champs" non trouvé. selecteur: ' + selector);
                        continue; // TODO meilleure gestion de cette erreur. Elle n'est pas
                                  // censée arriver et est critique ça va causer un corruption
                                  // du formulaire. (bouton inactifs, )
                    }
                    more_fields_button.
                    before(
                        newInputReferenceCadastrale()
                    );
                }
            }
        }
         /* Action sur les boutons [+ ajouter d'autres champs] et [+ ajouter 
          * d'autres lignes] */
        actionLineFormReferenceCadastrale();
        
        /* Ajoute les données dans les champs nouvellement créés */
        $('.reference_cadastrale_custom_field').each(
            function(index) {
                
                $(this).val(donnees[index])
            }
        );
    }
    else{
        actionFormReferenceCadastrale();
        actionLineFormReferenceCadastrale();
    }
}

/**
 * Ajoute les icônes pour la recherche de pétitionnaire fréquent.
 */
function addSearchIcon(){

    $("#form-content:not(.form-is-valid) .search_fields").each(
        function() {

            // N'ajoute pas l'icône de recherche sur la collectivité
            if ($(this).find("#om_collectivite").length <= 0) {

                //Ajout de l'icône après le champs dénomination et nom de la personne morale*/
                $(this).append(
                    '<span '+
                        'class="om-icon om-icon-16 om-icon-fix search-frequent-16" '+ 
                        'title="Chercher un frequent"> '+
                    '</span>'
                );
            }
        }
    );
    
    /*Ajout des actions sur les boutons*/
    addActionSearchIcon();
    addActionRemove();

}

/**
 * Fonction permettant de revenir sur le formulaire d'ajout de demandeur
 **/
function addActionRemove(){
    $('.erase-petitionnaire').click(
        function(){
            ajaxIt('petitionnaire','../app/index.php?module=sousform&obj=petitionnaire&action=0&retourformulaire=demande');
    });
    $('.erase-avocat').click(
        function(){
            ajaxIt('avocat','../app/index.php?module=sousform&obj=avocat&action=0&retourformulaire=demande');
    });
    $('.erase-bailleur').click(
        function(){
            ajaxIt('bailleur','../app/index.php?module=sousform&obj=bailleur&action=0&retourformulaire=demande');
    });
}

/**
 * Vérifie que les champs necessaires sont remplis et retourne les données necessaires
 * sous forme de tableau JSOn
 */
function getDataSearch(){

    // Récupèration de la valeur de la collectivité du dossier...
    var om_collectivite_value = $('#om_collectivite').val();
    // ... écrasée éventuellement par celle du demandeur
    if ($('#sousform-petitionnaire #om_collectivite').length) {
        om_collectivite_value = $('#sousform-petitionnaire #om_collectivite').val();
    }
    else if ($('#sousform-bailleur #om_collectivite').length) {
        om_collectivite_value = $('#sousform-bailleur #om_collectivite').val();
    }
    else if ($('#sousform-avocat #om_collectivite').length) {
        om_collectivite_value = $('#sousform-avocat #om_collectivite').val();
    }
    // Il faut un minimum de trois lettres pour lancer la recherche
    var minChar = false;
    // Récupération des données
    var dataJson = "{";
    $('.search_fields .champFormulaire').each(
        function(){
            if ( $(this).val().length >= 3 ){
                minChar = true;
            }
            
            var idInput = $(this).attr("id");
            var valInput = $(this).val();
            dataJson += "\"" + idInput + "\":\"" + valInput + "\",";
        }
    );

    // Si aucune collectivité est sélectionné
    if (om_collectivite_value == "") {
        //
        alert('Veuillez sélectionner une collectivité.');
        return "";
    }

    if (!minChar){
        alert('Saisissez au moins trois lettres pour la recherche');
        return "";
    }
    // Transformation de la chaîne de caractères en tableau
    dataJson = $.parseJSON(dataJson.substring(0,dataJson.length-1)+"}");
    // Mono : on définit la collectivité
    // Multi : on écrase la collectivité
    dataJson.om_collectivite = om_collectivite_value;
    // Retour des champs avec leur valeur
    return dataJson;
}

/*
 * Ajoute les actions sur les icônes de recherche
 */
function addActionSearchIcon(){
    
    //Selon l'objet dans lequel on se trouve
    var objName = '';
    var objReturn = '';
    if ( $('#sousform-petitionnaire').length == 1 ){
        objName = 'petitionnaire';
        objReturn = 'demande';
    }
    else if($('#architecte').length == 1){
        objName = 'architecte';
        objReturn = 'donnees_techniques';
    }
    else if($('#sousform-avocat').length == 1){
        objName = 'avocat';
        objReturn = 'demande';
    }
    else if($('#sousform-bailleur').length == 1){
        objName = 'bailleur';
        objReturn = 'demande';
    }
    $('.search-frequent-16').click(
        function(){
            //Récupération des données
            dataJson = getDataSearch();
            //Si ce n'est pas un tableau JSON on n'exécute pas le reste du code
            if ( typeof dataJson !== 'object' ){
                return;
            }
            
            //Requête qui va récupérer les données du addSearchIcon(es) 
            //pétitionnaire(s) correspondant(s) à la recherche
            $.ajax({
                type: "POST",
                dataType: "json",
                data: dataJson,
                url: "../app/find" + objName.charAt(0).toUpperCase() + objName.substring(1) + ".php" ,
                cache: false,
                success: function(obj){
                    var freq = obj;
                    var res='';
                    /*Si la recherche a donné des résultats*/
                    if ( freq.length > 0 ){
                        /*Limitation des résultats à 50 */
                        if ( freq.length > 50 ){
                            
                            nbRes = 50;
                            res += 'Votre recherche a donn&eacute; ' + freq.length 
                                + ' r&eacute;sultats. Seul les cinquantes premiers ' +
                                'seront affich&eacute;s.<br/>';
                        } else {
                            nbRes = freq.length;
                        }
                        
                        res += '<select id="select-'+objName+'">' ;
                        
                        /* Met les résultats de la recherche dans un select */
                       for ( i = 0 ; i < nbRes ; i++ ){
                            res += '<option value="' + freq[i].value + '">' + 
                                        freq[i].content +
                                   '</option>';
                        }
                        
                        res += '</select>';
                    } else {
                        res += 'Aucune correspondance trouvée.';
                    }
                    
                    addDivDialog('#sousform-' + objName);
                    /* Affichage de l'overlay */
                    $('#dialog').html(res);
                       
                    $( "#dialog" ).dialog({
                        dialogClass: "dialog-search-frequent-"+objName,
                        modal: true,
                        buttons : {
                            Valider: function(){
                                if ( res != 'Aucune correspondance trouvée.'){
                                    var id = $('#select-'+objName+' option:selected').val();
                                    if($.isNumeric(id)) {
                                        ajaxIt(objName,
                                        '../app/index.php?module=sousform&obj=' + objName + 
                                        '&action=110&retourformulaire=' + objReturn + 
                                        '&idx='+id
                                        );
                                    }
                                }
                                // Fermeture de l'overlay
                                $(this).dialog( "close" );
                                $(this).remove();
                            }
                        },
                        close: function(){
                            $(this).remove();
                        }
                    });
                },
            });
        }
    );
}

/*
 * Ajoute un div pour l'overlay dialog de jQuery
 */
function addDivDialog(id){
    
    $(id).prepend('<div id="dialog"></div>');

}

/*
    Action au changement du select de la qualite du demandeur
 * */
function changeDemandeurType(id){

    /*Réinitialise les champs et cache les champs inutiles selon la qualité du demandeur*/
    /*Si la qualite du demandeur est particulier */
    if ( $('#' + id ).val() == 'particulier' ) {
        
        $('.personne_morale_fields input').each(
            function(){
                $(this).val('');
            }
        );
        $('.personne_morale_fields select option[value=""]').each(
            function(){
                $(this).attr('selected', 'selected');
            }
        );
        
        $('.personne_morale_fields').hide();
        $('.particulier_fields').show();
    }
    /*Si c'est une personne morale*/
    else if ( $('#' + id ).val() == 'personne_morale' ) {
        
       $('.particulier_fields input').each(
            function(){
                $(this).val('');
            }
        );
        $('.particulier_fields select option[value=""]').each(
            function(){
                $(this).attr('selected', 'selected');
            }
        );
        
        $('.particulier_fields').hide();
        $('.personne_morale_fields').show();
    }
}

/*
    Fonction de test des champs
 * */
function isAlpha(str) {
    return /^[a-zA-Z\/]+$/.test(str);
}

function is_alpha_num(str) {
    return /^[a-zA-Z0-9\/]+$/.test(str);
}

function isMail(str){
    return /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(str);
}

function isPhoneNumber(str){
    return /[0-9-()+]{3,20}/.test(str);
}

function testSeparator(obj){

    if ( obj.value != 'A' && 
         obj.value != '/' ) {
             
        alert('Saisissez uniquement un A ou un / comme séparateur');
        obj.value = '';
    }
}

function isLetter(str) {
  return str.length === 1 && str.match(/[a-zA-Z]/i);
}

/**
 * Permet de vérifier que la valeur saisie dans un champ input est une chaîne de
 * caractères alphanumérique.
 * Le cas échéant, affiche un message d'erreur et supprime la valeur du champ.
 *
 * @return void
 */
function check_input_is_alpha_num(input, error_msg) {
    if (typeof(error_msg) == 'undefined') {
        error_msg = "Il ne s'agit pas d'une chaîne alphanumérique.";
    }
    if (input.value !== '' && is_alpha_num(input.value) === false) {
        alert(error_msg);
        input.value = '';
    }
}
/* Fin fonction test */

/*
 *  Ajoute les actions spécifiques pour le formulaire personnalisé d'ajout de
 *  référence cadastrale. (boutons "ajouter d'autres champs")
 *  Est appelée une fois par ligne de référence cadastrale et bind l'action sur
 *  le dernier boutton existant.
*/
function actionFormReferenceCadastrale(){

    if( $("form[name=f1] .form-is-valid").size() == 0) {

        var idx_last_line = $('.moreFieldReferenceCadastrale').length - 1;
        var selector = '#moreFieldReferenceCadastrale' + idx_last_line;
        /*Boutton "ajouter d'autres champs" (le dernier à ce moment là de l'exécution)*/
        var more_fields_button = $(selector);
        if (more_fields_button.length === 0) {
            console.error('Boutton "ajouter d\'autres champs" non trouvé. selecteur: ' + selector);
            return; // TODO meilleure gestion de cette erreur. Elle n'est pas
                    // censée arriver et est critique ça va causer un corruption
                    // du formulaire. (bouton inactifs, )
        }
        more_fields_button.
        on("click", function() {
            
            $(this).before(newInputReferenceCadastrale());
        });
    }
    
}

/*
 * Récupère les données saisies dans les champs de références cadastrales
 */
function getDataFieldReferenceCadastrale(){
    
    var reference_cadastrale = '';
    var reference_cadastrale_temp = '';
    var error = false;
    
    /*Pour chacun des champs du formulaire de saisie de référence cadastrale*/
    $('.reference_cadastrale_custom_field').each(
        function(){
            
            /*Si on est à la fin d'une ligne de champs*/
            if ( $(this).val() == ';' ){
                
                reference_cadastrale_bis = reference_cadastrale_temp ;
                
                /* Vérifie que les données sont correctement formatées avant de 
                 * les ajouter au résultat*/
                while( reference_cadastrale_bis != ''){
                    if ( /^([0-9]{1,4}[0-9a-zA-Z]{1,2}[0-9]{1,5}([A\/]{1}[0-9]{1,4})*)*$/.test(reference_cadastrale_bis) ){
                        
                        reference_cadastrale += reference_cadastrale_bis + ";";
                        break;
                    }
                    else{
                        alert("Les références cadastrales saisies sont incorrectes. Veuillez les corriger.");
                        error = true;
                        return false;
                    }    
                }
                
                reference_cadastrale_temp = '';
            }
            
            else {
                
                /*Sinon, on récupère la valeur du champ*/
                reference_cadastrale_temp += $(this).val();
            }
        }
    );
    
    if(error) return false;
    /*Met la valeur du résultat dans le champs généré par le framework*/
    $('#terrain_references_cadastrales').val(reference_cadastrale);
    return true;
}

/*
    Action pour l'ajout de nouvelle ligne dans le formulaire d'ajout 
    de référence cadastrale
 * */
function actionLineFormReferenceCadastrale(){

    if( $("form[name=f1] .form-is-valid").size() == 0) {

        $('#morelineReferenceCadastrale').click( 
            function(){
                
                /*Ajout des trois champs de base*/
                $('.reference_cadastrale_custom_fields').
                append( "<br/>" + fieldReferenceCadastraleBase());

                /*Ajout du bind pour l'ajout de nouveaux champs*/
                var idx_last_line = $('.moreFieldReferenceCadastrale').length - 1;
                var selector = '#moreFieldReferenceCadastrale' + idx_last_line;
                /*Boutton "ajouter d'autres champs" (le dernier à ce moment là de l'exécution)*/
                var more_fields_button = $(selector);
                if (more_fields_button.length === 0) {
                    console.error('Boutton "ajouter d\'autres champs" non trouvé. selecteur: ' + selector);
                    return; // TODO meilleure gestion de cette erreur. Elle n'est pas
                            // censée arriver et est critique ça va causer un corruption
                            // du formulaire. (bouton inactifs, )
                }
                more_fields_button.
                on("click", function() {
                    $(this).before(newInputReferenceCadastrale());
                });
            }
        );
    }
}


/**
 * Gestion du type de commission et de l'affichage des champs du formulaire
 * lors de la sélection de la collectivité.
 *
 * @return void
 */
function changeCommissionType(){

    var idCollectivite = $("#om_collectivite").val();

    // Si l'identifiant fourni est valide
    if ($.isNumeric(idCollectivite)){
        
        // Met à jour la liste déroulante des type de commission
        // avec les données correspondantes
        filterSelect(idCollectivite, 'commission_type', 'om_collectivite', 'commission');
    }
}


/**
 * Gestion du type de la demande
 * lors de la sélection du type de DA détaillé.
 *
 * @return void
 */
function changeDemandeType(tab_datd_dossier_platau){

    var idDossierAutorisationTypeDetaille = 
        $("#dossier_autorisation_type_detaille").val();

    // Récupère les données saisies dans les champs pour la référence cadastrale
    getDataFieldReferenceCadastrale();

    // Si l'identifiant fourni est valide
    if ( $.isNumeric(idDossierAutorisationTypeDetaille) ){

        // Si le champ 'demande_type' existe
        var demande_type_node = document.getElementById('demande_type');
        if (demande_type_node) {

            // Met à jour la liste déroulante du type de demande
            // avec les données correspondantes
            filterSelect(idDossierAutorisationTypeDetaille, 'demande_type', 'dossier_autorisation_type_detaille', 'demande');

            // récupère l'élément jQuery correspondant
            var demande_type_jq = $(demande_type_node);

            // Affiche la liste déroulante du type de demande
            demande_type_jq.parent().parent().show();

            // S'il n'y a qu'un seul type de demande
            // on le sélectionne et on le masque
            if ($('#demande_type option').size() === 2) {
                var idx_type_demande = $('#demande_type option').eq(1).val();
                demande_type_jq.val(idx_type_demande);
                //demande_type_jq.trigger('change');
                demande_type_jq.parent().parent().hide();
            }
        }
    }
}

/*
 * Renvoi 'true' si le formulaire de la dmande est déjà affiché en entier, 'false' sinon.
 *
 */
function isNouvelleDemandeFormDisplayed() {
    var date_demande_node = document.getElementById('date_demande');
    var type_of_date_demande_node = typeof(date_demande_node);
    if (type_of_date_demande_node != 'undefined' && type_of_date_demande_node != null) {
        return $(date_demande_node).is(":visible");
    }
    return false;
}

/*
 * Affiche le formulaire de demande, en fonction du DAtd et de la demande type
 *
 * @return void
 */
function afficheFormDemandeDAtd(hideWhenAlreadyAForm = 0) {

    var idDossierAutorisationTypeDetaille =
        $("#dossier_autorisation_type_detaille").val();

    // Si l'identifiant fourni est valide
    if ($.isNumeric(idDossierAutorisationTypeDetaille)) {

        // si on a demandé à masquer les champs d'abord (avant de les ré-afficher)
        var hideSec = 0;
        if (isNouvelleDemandeFormDisplayed()) {
            hideFields();
            hideSec = hideWhenAlreadyAForm;
        }
        setTimeout(function () {

            // S'il n'y a qu'un seul type de demande on affiche les champs d'après
            if ($('#demande_type option').size() === 2) {
                manage_display_demande(idDossierAutorisationTypeDetaille);
            }

            // S'il n'y a pas de type de demande
            // on affiche directement les champs d'après
            else if ($('#demande_type option').size() < 2) {
                showFormDemande();
            }

            // sinon on affiche le champ
            else {
                $('#demande_type').parent().parent().show();
            }

            // Si aucune option n'est sélectionnée on masque les champs d'après
            if($('#demande_type').val() == '' ) {
                hideFields(false); // masquer les champs mais pas 'demande_type'
                $('input[type=submit]').hide();
            }
        }, hideSec);
    }

    // Sinon on cache tous les champs du formulaire
    else {
        hideFields();
    }
}

/*
 * Affiche le formulaire de demande, en fonction de la demande type
 *
 * @return void
 */
function afficheFormDemandeDT(hideWhenAlreadyAForm = 0) {
    // si on a demandé à masquer les champs d'abord (avant de les ré-afficher)
    var hideSec = 0;
    if (isNouvelleDemandeFormDisplayed()) {
        hideFields(false); // ne pas masquer le champ 'type de demande'
        hideSec = hideWhenAlreadyAForm;
    }
    setTimeout(function () {

        // appelle de la "vraie" fonction d'affichage du formulaire
        showFormDemande();
    }, hideSec);
}

/**
 * Méthode permettant d'afficher ou de cacher les champs signaiter et type de rédaction
 * lors de l'ajout d'une instruction.
 *
 * @param {evenement_id}  integer Identifiant de l'événement sélectionné
 * @param {idxformulaire} string  Identifiant du DI de l'instruction en cours d'ajout
 *
 * @return void
 */
function manage_instruction_evenement_lettretype(evenement_id, idxformulaire) {
    // Lien
    link = "../app/index.php?module=form&obj=instruction&action=300&idx=0&idxformulaire=" + idxformulaire + "&evenement_id=" + evenement_id;
    // Traitement
    $.ajax({
        type: "GET",
        url: link,
        cache: false,
        dataType: "json",
        success: function(data) {
            if (data.lettretype === true) {
                $('#signataire_arrete').parent().parent().show();
                if (data.option_redaction_libre_enabled === true) {
                    $('#flag_edition_integrale').parent().parent().show();
                }

                // Si on a une lettre type qui est associé au dossier
                // Récupération de la valeur du onsubmit pour la modifier et la faire passer à retour=form au lieu de retour=tab
                var new_link_onsubmit = $('div#sousform-container form')[0].getAttribute("onsubmit").replace('retour=tab', 'retour=form');
                // On réinjecte le contenu du "onsubmit" modifié dans la balise concernée
                $('div#sousform-container form').attr("onsubmit", new_link_onsubmit)

                // Récupération de la valeur du data-href pour la modifier et la faire passer à retour=form au lieu de retour=tab
                var new_data_href_link = document.getElementById("sousform-href").getAttribute('data-href').replace('retour=tab', 'retour=form')
                $('div#sousform-href').attr("data-href", new_data_href_link)

            } else {
                $('#signataire_arrete').parent().parent().hide();
                $('#flag_edition_integrale').parent().parent().hide();

                // Modification/simplification du parcours utilisateur lors de l'ajout d'une instruction et si aucune lettre type n'est associé au dossier
                // Récupération de la valeur du onsubmit pour la modifier et la faire passer à retour=tab au lieu de retour=form
                var new_link_onsubmit = $('div#sousform-container form')[0].getAttribute("onsubmit").replace('retour=form', 'retour=tab');
                // On réinjecte le contenu du "onsubmit" modifié dans la balise concernée
                $('div#sousform-container form').attr("onsubmit", new_link_onsubmit)

                // Récupération de la valeur du data-href pour la modifier et la faire passer à retour=tab au lieu de retour=form
                var new_data_href_link = document.getElementById("sousform-href").getAttribute('data-href').replace('retour=form', 'retour=tab')
                $('div#sousform-href').attr("data-href", new_data_href_link)
            }
        },
        async: false,
    });
}

/**
 * Méthode permettant d'afficher ou de cacher le champs commentaire lors de l'ajout d'une instruction.
 *
 * @param {evenement_id}  integer Identifiant de l'événement sélectionné
 * @param {idxformulaire} string  Identifiant du DI de l'instruction en cours d'ajout
 *
 * @return void
 */
function manage_instruction_evenement_commentaire(evenement_id, idxformulaire) {
    // Lien
    link = "../app/index.php?module=form&obj=instruction&action=301&idx=0&idxformulaire=" + idxformulaire + "&evenement_id=" + evenement_id;
    // Traitement
    $.ajax({
        type: "GET",
        url: link,
        cache: false,
        dataType: "json",
        success: function(data) {
            if (data.commentaire === true) {
                $('#commentaire').parent().parent().show();
                // Permet de correctement possitionner le champ
                $('#commentaire').parent().parent().attr('style', 'display: table-row');
            } else {
                $('#commentaire').parent().parent().hide();
                $('#commentaire').val("");
            }
        },
        async: false,
    });
}
/*
    Ajoute le code HTML des champs pour les références cadastrales
 * */
function addNewFieldReferencesCadastrales(){

    // Nettoyage des bouttons "ajouter d'autres champs" car dans
    // fieldReferenceCadastraleBase() appelée ci-après, on compte le nombre de
    // bouttons. Et si on les supprimes après, on aura pas exemple le nouveau
    // bouton en position 0 mais avec l'id 2. Ce qui va causer des bugs.
    $('.moreFieldReferenceCadastrale').remove();

    var html = '<div class="field field-type-text references_cadastrales_new_field" >'+
            '<div class="form-libelle">' +
                '<label '+
                    'class="libelle-terrain_references_cadastrales" '+
                    'for="terrain_references_cadastrales">'+
                    ' Références cadastrales '+
                '</label>' +
            '</div>' +
            '<div class="form-content reference_cadastrale_custom_fields">' +
                 fieldReferenceCadastraleBase() +
            '</div>' +
        '</div>';
    
    url = document.location + "";
    demandeInfo = getDemandeInfo('nature');
    if((demandeInfo == 'NOUV' || demandeInfo == 'NONE' ) && $(".form-is-valid").size() == 0 && url.indexOf('action=3') == -1 ) {
        html += '<div class="field field-type-text" id="morelineReferenceCadastrale">' +
            '<div class="form-libelle"></div>' +
            '<div class="form-content">' +
                '<span class="om-form-button add-16" title="Ajouter">ajouter d\'autres lignes</span>' +
            '</div>' +
       '</div>';
    }

    $('.references_cadastrales_new_field').remove();
    $('#morelineReferenceCadastrale').remove();
    $('#terrain_references_cadastrales').parent().parent().before(
        html
    );
}

function addButtonCadastraleAdesse(){

    // Permet d'ajouter le bouton de récupération d'adresse si sig activé
    if ($('#option_sig').val() == 'sig_externe'){
    
        $('#terrain_references_cadastrales').parent().parent().after('<div class="field field-type-text recupAdresseButton" >' +
            '<div class="form-libelle"></div>' +
            '<div class="form-content buttonCadAdr">' +
                '<input id="cad-adr-them" '+
                    'class="ui-button ui-widget ui-state-default ui-corner-all" '+
                    'type="button" '+
                    'onclick="getAdressFromCadastrale();" '+
                    'value="Récupérer l\'adresse de la parcelle"/>' +
            '</div>' +
       '</div>' );
    }
}

/*
    Séparateur caché ; pour marqué la fin d'une ligne de référence cadastrale
 * */
function hiddenSeparatorField(){

    return '<input ' +
                'class="reference_cadastrale_custom_field" ' +
                'type="hidden" ' +
                'maxlength="2" ' +
                'size="2" ' +
                'value=";" />';
}

/**
 * Retourne l'info passée en paramètre parmi trois possibilités:
 * - la nature de la demande
 * - le type de demande est à avec_recup (de petitionnaire)
 * - le type d'affichage
 **/
function getDemandeInfo(info) {
    var id_demande_type = $('#demande_type').val();
    var res = "";
    if ( typeof id_demande_type !== "undefined" && id_demande_type !== ''){
        $.ajax({
            type: "GET",
            url: "../app/getDemandeInfo.php?iddemandetype=" + id_demande_type
                    + "&info=" + info,
            cache: false,
            async: false,
            success: function(val){
                res = val;
            }
        });
    }
    else {
        
        res = "NONE"
    }
    return res;
}
/*
    Ajout d'une nouvelle ligne de champ de référence cadastrale
    Retourne le code HTML
 * */
function fieldReferenceCadastraleBase(){
    
    url = document.location + "";
    
    var type = getDemandeInfo('nature');
    var reference_cadastrale = '<input ' +
                'class="champFormulaire reference_cadastrale_custom_field" ' +
                'type="text" ' +
                'onchange="VerifNum(this);str_pad_js(this, 3);" ' + 
                'maxlength="3" ' +
                'size="3" '+ 
                'placeholder="Quart." ';
                
    // désactivation des champs de référence cadastrale
    var urlParams = extractUrlParams();
    var obj = 'obj' in urlParams ? urlParams['obj'] : null;
    // si on est sur l'objet correspondant à une nouvelle demande
    if((obj !== 'demande_nouveau_dossier'
            && obj !== 'demande_nouveau_dossier_contentieux'
            && type != 'NOUV'
            && type != 'NONE')
        || $(".form-is-valid").size() > 0
        || url.indexOf('action=3') != -1 ) {
        //
        reference_cadastrale += 'disabled="disabled" ';
    }
    
    reference_cadastrale += 'value="" />';

    reference_cadastrale += '<input ' +
                'class="champFormulaire reference_cadastrale_custom_field" ' +
                'type="text" ' +
                'maxlength="2" ' +
                'size="2" '+ 
                'placeholder="Sect." ';
    
    // désactivation des champs de référence cadastrale
    // si on est sur l'objet correspondant à une nouvelle demande
    if((obj !== 'demande_nouveau_dossier'
            && obj !== 'demande_nouveau_dossier_contentieux'
            && type != 'NOUV'
            && type != 'NONE')
        || $(".form-is-valid").size() > 0
        || url.indexOf('action=3') != -1 ) {
        //
        reference_cadastrale += 'disabled="disabled" ';
    }
    
    reference_cadastrale += 'value="" '+
                'onchange="this.value=this.value.toUpperCase();check_input_is_alpha_num(this);str_pad_js(this, 2);"/>';
    reference_cadastrale += '<input ' +
                'class="champFormulaire reference_cadastrale_custom_field" ' +
                'type="text" ' +
                'onchange="VerifNum(this);str_pad_js(this, 4);" ' + 
                'maxlength="4" ' +
                'size="4" '+ 
                'placeholder="Parc." ';
    
    // désactivation des champs de référence cadastrale
    if((obj !== 'demande_nouveau_dossier'
            && obj !== 'demande_nouveau_dossier_contentieux'
            && type != 'NOUV'
            && type != 'NONE')
        || $(".form-is-valid").size() > 0
        || url.indexOf('action=3') != -1 ) {
        //
        reference_cadastrale += 'disabled="disabled" ';
    }
    
    reference_cadastrale += 'value="" />';

    reference_cadastrale += '<span id="moreFieldReferenceCadastrale' +
        $('.moreFieldReferenceCadastrale').length +
        '" class="moreFieldReferenceCadastrale">' + hiddenSeparatorField();

    // Si form validé pas de bouton
    url = document.location + "";
    if((obj === 'demande_nouveau_dossier'
            || obj === 'demande_nouveau_dossier_contentieux')
        || (type == 'NOUV'
            || type == 'NONE')
        && $("form[name=f1] .form-is-valid").size() == 0
        && url.indexOf('action=3') == -1 ) {
        //
        reference_cadastrale += 
            '<span class="om-form-button add-16" title="Ajouter">ajouter d\'autres champs</span>';
    }

    reference_cadastrale += '</span>';
    
    return reference_cadastrale;
}

/**
 * Cache les champs inutules [formulaire de demande]
 **/
function hideFields(hideDemandeType = true){
    $('.demande_hidden_bloc').each(
        function(){
            $(this).hide();
        }
    );
    $('.field-type-text').hide();
    $('input[type=submit]').hide();
    if (hideDemandeType) {
        $('#demande_type').parent().parent().hide();
    }
}

/**
 * Gestion de la checklist des documents obligatoires, fonction appelée onchange
 * du champ demande_type.
 *
 * @param node demande_type champ demande_type
 */
function manage_document_checklist(demande_type) {
    // Appel de la vue correspondante à l'action 100 de l'objet demande_type
    $.getJSON( "../app/index.php?module=form&obj=demande_type&action=100&idx="+$(demande_type).val(), function( data ) {
        if(data != false) {
            // Si l'action retourne une autre valeur que false on affiche la checklist
            show_document_checklist(data);
        }
    });
}

/**
 * Affichage et gestion du comportement de la checklist des documents obligatoires.
 *
 * @param {obj} data Objet correspondant au json retourné par l'action 100 de demande_type
 */
function show_document_checklist(data) {

    // Préparation du contenu du dialog
    var html_list = "<div id='liste_doc'><form><ul>";
    // Une checkbox par document obligatoire
    $.each(data.documents, function( key, value) {
        html_list += "<li><input type='checkbox' name='"+key+"'/> "+value+"</li>"
    });
    html_list += "</ul></form></div>";

    // Création de la fonction de vérification des checkbox cochées appelée lors
    // de la fermeture du dialog
    var check_doc = function(){
        // Si le nombre de checkbox cochées ne correspond pas au nombre de doc
        // fournis par l'action 100 de demande_type on affiche un message d'erreur
        // et bloque la fermeture du dialog
        if(data.documents.length != $("#liste_doc form input:checked").length) {
            alert(data.message_ko);
            return false;
        }
    }
    // Définition des boutons du dialog
    var dialog_buttons = {};
    dialog_buttons[data.libelle_cancel] = function(){
        // Si Rejet de la demande, affichage d'un message de confirmation et rechargement
        if(window.confirm(data.message_rejet)) {
            location.reload();
        }
    }
    dialog_buttons[data.libelle_ok] = function(){
        // Si validation du dialog : fermeture
        $(this).dialog('close');
    }
    // Insertion dans le dom du dialog non instancié
    $("html").append(html_list);
    // Instanciation du dialog
    $( "#liste_doc" ).dialog({
        title: data.title,
        resizable: false,
        modal: true,
        buttons: dialog_buttons,
        // Action avant fermeture : verification des checkbox cochées
        beforeClose: check_doc
    });
}

/*
    Affiche les champs dont on a besoin dans le formulaire de demande
 * */
function showFormDemande(){

    if($('#demande_type').val() != "") {

        $('.demande_hidden_bloc').each(
            function(){
                $(this).show();
            }
        );
        formatFieldReferenceCadastrale();
        $('.field-type-text').show();
        $('input[type=submit]').show();
        $('.terrain_references_cadastrales_custom').hide();

        $('#terrain_references_cadastrales').parent().parent().hide();

        //Vérification des contraintes de récupération des demandeurs si 
        // pas de récupération, on efface la liste
        var demandeInfo = getDemandeInfo('contraintes');
        var urlParams = extractUrlParams();
        var obj = 'obj' in urlParams ? urlParams['obj'] : null;
        // si on est sur l'objet correspondant à une nouvelle demande
        if (obj !== 'demande_nouveau_dossier'
            && obj !== 'demande_nouveau_dossier_contentieux') {
            //
            if (demandeInfo == 'sans_recup') {
                if($('input[name^=petitionnaire_principal]').size() != -1) {
                    removeDemandeur("petitionnaire_principal_" + $('input[name^=petitionnaire_principal]').val());
                }
                if($('input[name^=delegataire]').size() != -1) {
                    removeDemandeur("delegataire_" + $('input[name^=delegataire]').val());
                }
            if($('input[name^=proprietaire]').size() != -1) {
                removeDemandeur("proprietaire_" + $('input[name^=proprietaire]').val());
            }
            if($('input[name^=architecte_lc]').size() != -1) {
                removeDemandeur("architecte_lc_" + $('input[name^=architecte_lc]').val());
            }
            if($('input[name^=paysagiste]').size() != -1) {
                removeDemandeur("paysagiste_" + $('input[name^=paysagiste]').val());
            }

                $('#listePetitionnaires input.demandeur_id').each(function(){
                    if($(this).size() != -1) {

                        removeDemandeur("petitionnaire_" + $(this).val());
                    }
                });
            } else if (demandeInfo !== 'sans_recup'
                    && demandeInfo !== ''
                    && demandeInfo !== null) {
                //Récupération des demandeurs si la contrainte le permet
                $.ajax({
                    type: "GET",
                    url: "../app/getDemandeurList.php?dossier_autorisation=" + $('#dossier_autorisation').val() + "&contraintes=" + demandeInfo,
                    cache: false,
                    async: false,
                    success: function(html){
                        $('#liste_demandeur').replaceWith(html);
                    }
                });
            }
        }
        affichageBoutonsDemandeurs();
    } else {

        /*Récupère les references cadastrales*/
        getDataFieldReferenceCadastrale();

        $('.demande_hidden_bloc').each(
            function(){
                $(this).hide();
            }
        );
        $('input[type=submit]').hide();

    }
}

function lookingForAutorisationContestee() {
    // Récupération de l'identifiant du dossier contesté sans espace.
    var idx = $('#autorisation_contestee').val().replace(/\s+/g,'');
    idx = $.trim(idx);
    $('#autorisation_contestee').val(idx);
    // Initialisation du bloc de message d'erreur.
    var error_message = 
    '<div ' +
        'class="message ui-widget ui-corner-all ui-state-highlight ui-state-error">' +
        '<p>' +
            '<span class="ui-icon ui-icon-info"></span>' +
            '<span class="text">' +
                '{0}' +
            '</span>' +
        '</p>' +
    '</div>';
    // On vide les demandeurs possiblement déjà présents dans le formulaire
    // puisqu'ils vont être récupérés depuis le dossier contesté.
    $('.petitionnaire_principal').each(function() {
        $(this).remove();
    });
    $('.delegataire').each(function() {
        $(this).remove();
    });
    $('.petitionnaire').each(function() {
        $(this).remove();
    });
    $('.avocat').each(function() {
        $(this).remove();
    });
    $('.requerent').each(function() {
        $(this).remove();
    });
    $('.plaignant').each(function() {
        $(this).remove();
    });
    $('.contrevenant').each(function() {
        $(this).remove();
    });
    $('.bailleur').each(function() {
        $(this).remove();
    });
    $('.proprietaire').each(function() {
        $(this).remove();
    });
    $('.architecte_lc').each(function() {
        $(this).remove();
    });
    $('.paysagiste').each(function() {
        $(this).remove();
    });
                    
    if (idx != '') {
        $('#form-message').html(msg_loading);
        //
        $.ajax({
            type: "POST",
            url: "../app/index.php?module=form&obj=dossier_instruction&action=220&idx="+idx+"&validation=1&contentonly=true",
            cache: false,
            data: "submit=plop&",
        }).done(function(json) {
            
            var infos_dossier = jQuery.parseJSON(json);
            if (infos_dossier.hasOwnProperty('error')) {
                $('#autorisation_contestee').val('');
                // Ajout du contenu récupéré (uniquement le bloc message)
                $('#form-message').html(error_message.format(infos_dossier.error));
                return false;
            }
            $('#autorisation_contestee_search_button').prop('disabled', true);
            $('#autorisation_contestee_search_button').button('option', 'disabled', true);
            $('#autorisation_contestee').prop('readonly', true);
            $('#form-message').html('');
            // Affichage des valeurs de formulaires
            $.each(infos_dossier, function( index, value ) {
                if ($('#'+index).length == 1) {
                    $('#'+index).val(value);
                }
            });
            // Affichage des demandeurs
            afficherDemandeur(infos_dossier.demandeurs.petitionnaire_principal, 'petitionnaire_principal');
            if (infos_dossier.demandeurs.hasOwnProperty("delegataire") == true) {
                afficherDemandeur(infos_dossier.demandeurs.delegataire, 'delegataire');
            }
            if (infos_dossier.demandeurs.hasOwnProperty("petitionnaire") == true) {
                $.each(infos_dossier.demandeurs.petitionnaire, function( type, id ) {
                    afficherDemandeur(id, 'petitionnaire');
                });
            }
            showFormDemande();
        });


    }
}

function eraseAutorisationContestee(){
    $('#autorisation_contestee_search_button').prop('disabled', false);
    $('#autorisation_contestee_search_button').button('option', 'disabled', false);
    $('#autorisation_contestee').prop('readonly', false);
    $('#autorisation_contestee').val('');
    hideFields();
}

/*
    Action au clique sur le bouton " + ajouter d'autres champs"
 * */
function newInputReferenceCadastrale(){
    
    // Champs désactivé si le formulaire a été validé et est valide
    var type = getDemandeInfo('nature');
    var reference_cadastrale_disabled = '';
    var urlParams = extractUrlParams();
    var obj = 'obj' in urlParams ? urlParams['obj'] : null;
    // si on est sur l'objet correspondant à une nouvelle demande
    if((obj !== 'demande_nouveau_dossier'
            && obj !== 'demande_nouveau_dossier_contentieux'
            && type != 'NOUV'
            && type != 'NONE')
        || $(".form-is-valid").size() > 0
        || url.indexOf('action=3') != -1 ) {
        //
        reference_cadastrale_disabled = 'disabled="disabled" ';
    }
    
    return '<input ' +
            'class="champFormulaire reference_cadastrale_custom_field" ' +
            'type="text" ' +
            'maxlength="1" ' +
            'size="3" ' +
            'value="" ' + 
            'placeholder="Sep." ' + 
            reference_cadastrale_disabled +
            'onchange="testSeparator(this);"/>' +
        '<input ' +
            'class="champFormulaire reference_cadastrale_custom_field" ' +
            'type="text" ' +
            'onchange="VerifNum(this);str_pad_js(this, 4)" ' + 
            'maxlength="4" ' +
            'size="4" ' +
            'placeholder="Parc." ' + 
            reference_cadastrale_disabled +
            'value="" />';
}

/**
 * Permet d'éventuellement lancer des scripts spécifiques à l'application.
 */
function app_initialize_content(tinymce_load) {
    // On cache les champs de recherche sousform pour les listing specifiques 
    if ($('#sousform-document_numerise').exists()
        || $('#sousform-dossier_autorisation').exists()
        || $('#sousform-dossier_contrainte').exists()
        || $('#sousform-lien_dossier_tiers').exists()) {

        $('#recherche_onglet').hide();
    }

    // Si l'onglet consultatione existe
    if ($('#sousform-consultation').exists()) {
        // Si le champ de recherche de l'onglet à dans son attribut onkeyup
        // la chaîne de caractère 'retourformulaire=demande_avis'
        if ($('#recherche_onglet input#recherchedyn').exists()
            && $('#recherche_onglet input#recherchedyn').attr("onkeyup").match(/retourformulaire=demande_avis/g) !== null) {
            //
            // On cache le champ de recherche sousform
            $('#recherche_onglet').hide();
        }
    }
    changeDemandeurType('qualite');
    addSearchIcon();
    addDivDialog('.bloc_demandeur');
    // Interface de gestion de la commission
    commission_manage_interface();
    // Bind actions afficher les données technique depuis les lots
    $('a[id^=action-sousform-lot][id$=-donnees_techniques]').each(function(){
        $(this).bind_action_for_overlay("donnees_techniques");
    });

    // Bind des actions après le rafraichissement.
    initBindFocus();

    // Bind actions afficher les données technique depuis les lots
    $('a[id^=action-sousform-lot][id$=-donnees_techniques]').each(function(){
        $(this).bind_action_for_overlay("donnees_techniques");
    });

    // Fermeture overlay sur clic bouton retour
    $("#sousform-donnees_techniques a.retour").off('click').on('click', function(event) {
        $('#sousform-donnees_techniques').dialog('close').remove();
        // Rechargement du formulaire en fond de page
        form_container_refresh("form");
        return false;
    });
    $("#sousform-architecte a.retour").off('click').on('click', function(event) {
        $('#sousform-architecte').dialog('close').remove();
        return false;
    });
    $("#sousform-demande_avis_encours a.retour").off('click').on('click', function(event) {
        $('#sousform-demande_avis_encours').dialog('close').remove();
        return false;
    });
    $("#sousform-rapport_instruction a[id^=sousform-action-rapport_instruction-back]").off('click').on('click', function(event) {
        $('#sousform-rapport_instruction').dialog('close').remove();
        return false;
    });
    $("#sousform-instruction_preview_edition a.retour").off('click').on('click', function(event) {
        $('#sousform-instruction_preview_edition').dialog('close').remove();
        return false;
    });
    $("#sousform-document_numerise_preview_edition a.retour").off('click').on('click', function(event) {
        $('#sousform-document_numerise_preview_edition').dialog('close').remove();
        return false;
    });

    var myObj = '';
    if ($('#sousform-lien_dossier_dossier').exists()) {
        myObj = 'lien_dossier_dossier';
    }
    if ($('#sousform-lien_dossier_dossier_contexte_ctx_re').exists()) {
        myObj = 'lien_dossier_dossier_contexte_ctx_re';
    }
    if ($('#sousform-lien_dossier_dossier_contexte_ctx_inf').exists()) {
        myObj = 'lien_dossier_dossier_contexte_ctx_inf';
    }
    // Onglet "Dossiers Liés" du DI
    if (myObj !== '' && $('#action-soustab-dossier_lies-corner-ajouter').exists()) {

        // Étant donné que la vue spécifique comporte trois tableaux
        // et que l'action "Ajouter" d'un tableau remplace uniquement
        // celui-ci par le formulaire, on redéfinit son comportement
        // en chargeant ce formulaire dans l'onglet entier.
        $('#action-soustab-dossier_lies-corner-ajouter').prop('onclick', null).off('click').on('click', function() {
            // On récupère le lien de l'action passé dans la foncion JS ajaxIt() appelée dans le onclick
            var on_click = $(this).attr('onclick');
            var reg = new RegExp(/^ajaxIt\('.*','(.*)'\);$/);
            var res = reg.exec(on_click);
            if (res !== null) {
                var link_action = res[1];
                ajaxIt(myObj, link_action);
            }
            return false;
        });
        // De même on affiche le message de validation des actions-direct
        // en entête de l'onglet au lieu du tableau concerné.
        $('#sousform-dossier_lies a.action-direct').prop('onclick', null).off('click').on('click', function() {
            // On récupère le lien de l'action passé dans la foncion JS ajaxIt() appelée dans le onclick
            var on_click = $(this).attr('onclick');
            var reg = new RegExp(/^ajaxIt\('.*','(.*)'\);$/);
            var res = reg.exec(on_click);
            if (res !== null) {
                var link_action = res[1] + '&validation=1&contentonly=true';
                var link_tab = $('#tab_dossier_lies_href').attr('data-href');
                var msg_container = '#sousform-' + myObj + ' > .soustab-message';
                var tab_container = '#sousform-dossier_lies .soustab-container';
                $(msg_container).html(msg_loading);
                //
                $.ajax({
                    type: "POST",
                    url: link_action,
                    cache: false,
                    success: function(html){
                        // Ajout du contenu récupéré (uniquement le bloc message)
                        $(msg_container).html($(html).find('div.message').get(0));
                        // Rafraichissement du tableau
                        
                        $.get(link_tab, function(html_content) {
                            $(tab_container).html(html_content);
                            om_initialize_content();
                        });
                    }
                });
            }
            return false;
        });
    }
    // Ce code sert à gérer le comportement des actions d'ajout et de suppression de l'onglet acteur.
    if ($('#sousform-lien_dossier_tiers').exists()) {
        myObj = 'lien_dossier_tiers';
        // Étant donné que la vue peux comporter plusieurs tableau et que l'action "Ajouter" d'un
        // tableau remplace uniquement celui-ci par le formulaire, on redéfinit son comportement
        // en chargeant ce formulaire dans l'onglet entier.
        $('#action-soustab-' + myObj + '-corner-ajouter').prop('onclick', null).off('click').on('click', function() {
            // Récupère le lien de l'action passé dans la foncion JS ajaxIt() appelée dans le onclick
            // et recharge la page en utilisant ce lien
            var on_click = $(this).attr('onclick');
            var reg = new RegExp(/^ajaxIt\('.*','(.*)'\);$/);
            var res = reg.exec(on_click);
            if (res !== null) {
                var link_action = res[1];
                ajaxIt('lien_dossier_tiers', link_action);
            }
            return false;
        });
        
        // Gestion des action-direct
        $('a[id^="action-soustab-' + myObj + '"].action-direct').prop('onclick', null).off('click').on('click', function() {
            // Récupère le lien de l'action passé dans la foncion JS ajaxIt() appelée dans le onclick
            // Si rien n'a été récupéré, ne fais rien.
            // Si le lien a été récupéré, construis l'url de l'action avec ce lien pour ne récupérer que
            // le message de retour. Effectue ensuite une requête ajax avec cette url pour récupérer
            // le message de traitement.
            // Pour finir recharge le formulaire en utilisant l'url récupéré dans la balise #back_link et
            // modifie le html pour afficher le tableau à jour et le message de traitement.
            var on_click = $(this).attr('onclick');
            var reg = new RegExp(/^ajaxIt\('.*','(.*)'\);$/);
            var res = reg.exec(on_click);
            if (res !== null) {
                var link_action = res[1] + '&validation=1&contentonly=true';
                var link_tab = $('#back_link').attr('data-href');
                $.ajax({
                    type: "POST",
                    url: link_action,
                    cache: false,
                    success: function(html){
                        // Ajout du contenu récupéré (uniquement le bloc message)
                        message = $(html).find('div.message').get(0);
                        // Rafraichissement du tableau
                        $.get(link_tab, function(html_content) {
                            $('#sousform-' + myObj).html(html_content);
                            $('#sousform-message').html(message);
                            om_initialize_content();
                        });
                    }
                });
            }
            return false;
        });
    }

    // Chosen multiple servant a sélectionner la liste des tiers acteur du dossier
    $("div#sousform-lien_dossier_tiers select#tiers").parents('div.formEntete').css("overflow", "visible");
    $("div#sousform-lien_dossier_tiers select#tiers option[value='']").empty();
    $("div#sousform-lien_dossier_tiers select#tiers").chosen({
        width: "300px",
        placeholder_text_single: "Sélectionner les acteurs",
        no_results_text: "Aucun résultat",
        allow_single_deselect: true
    });
    // Change la liste à choix de l'événement sur l'instruction avec chosen
    // Le div.formEntete doit avoir sa propriété overflow à visible pour que le
    // contenu de la liste à choix soit correctement affiché
    $("div.sousform-instruction-action-0").parents('div.formEntete').css("overflow", "visible");
    $("div.sousform-instruction-action-0 select#evenement option[value='']").empty();
    $("div.sousform-instruction-action-0 select#evenement").chosen({
        width: "300px",
        placeholder_text_single: "Choisir l'événement",
        no_results_text: "Aucun résultat",
        allow_single_deselect: true
    });

    // Change la liste à choix des tiers sur la notification des tiers avec chosen
    // Le div.formEntete doit avoir sa propriété overflow à visible pour que le
    // contenu de la liste à choix soit correctement affiché
    $("div#sousform-instruction_notification_manuelle div.formEntete").css({"overflow":"visible","border":"none"});
    $("div#sousform-instruction_notification_manuelle").css("overflow", "visible");
    $("div#sousform-instruction_notification_manuelle").parent('div.ui-dialog.ui-widget-content').css("overflow", "visible");
    $("div#sousform-instruction_notification_manuelle select#tiers_consulte option[value='']").empty();
    $("div#sousform-instruction_notification_manuelle select#tiers_consulte").chosen({
        width: "300px",
        placeholder_text_single: "Choisir les tiers à notifier",
        no_results_text: "Aucun résultat",
        allow_single_deselect: true
    });
    // Chosen multiple servant a sélectionner la liste des annexes a envoyer lors de la notif des services/tiers
    // ainsi que la liste des documents et des pièces annexes pour la notification des demandeurs
    $("div#sousform-instruction_notification_manuelle select[id^=annexes] option[value='']").empty();
    $("div#sousform-instruction_notification_manuelle select[id^=annexes]").chosen({
        width: "300px",
        placeholder_text_single: "Sélectionner les annexes",
        no_results_text: "Aucun résultat",
        allow_single_deselect: true
    });


    // Change la liste à choix du type de document pour les pièces d'un dossier avec chosen
    // Le div.formEntete doit avoir sa propriété overflow à visible pour que le
    // contenu de la liste à choix soit correctement affiché
    // En ajout
    $("div.sousform-document_numerise-action-0").parents('div.formEntete').css("overflow", "visible");
    $("div.sousform-document_numerise-action-0 select#document_numerise_type option[value='']").empty();
    $("div.sousform-document_numerise-action-0 select#document_numerise_type").chosen({
        width: "300px",
        placeholder_text_single: "Choisir le type de pièce",
        no_results_text: "Aucun résultat",
        allow_single_deselect: true
    });
    // En modification
    $("div.sousform-document_numerise-action-1").parents('div.formEntete').css("overflow", "visible");
    $("div.sousform-document_numerise-action-1 select#document_numerise_type option[value='']").empty();
    $("div.sousform-document_numerise-action-1 select#document_numerise_type").chosen({
        width: "300px",
        placeholder_text_single: "Choisir le type de pièce",
        no_results_text: "Aucun résultat",
        allow_single_deselect: true
    });

    // Chosen multiple servant a sélectionner la division territoriale d’intervention commune
    $("select#division_territoire_intervention_commune option[value='']").empty();
    $("select#division_territoire_intervention_commune").chosen({
        width: "300px",
        placeholder_text_single: "Sélectionner les communes",
        no_results_text: "Aucun résultat",
        allow_single_deselect: true
    });
    // Chosen multiple servant a sélectionner la division territoriale d’intervention département
    $("select#division_territoire_intervention_departement option[value='']").empty();
    $("select#division_territoire_intervention_departement").chosen({
        width: "300px",
        placeholder_text_single: "Sélectionner les departements",
        no_results_text: "Aucun résultat",
        allow_single_deselect: true
    });

    // url de la page
    url = document.location + "";
    if (url.indexOf("index.php?module=tab&") == -1) {
        // Chosen multiple servant a sélectionner la nature de travaux
        $("select#nature_travaux option[value='']").empty();
        $("select#nature_travaux").chosen({
            width: "300px",
            placeholder_text_single: "Sélectionner les natures de travaux",
            no_results_text: "Aucun résultat",
            allow_single_deselect: true
        });
    }
    // Chosen servant à sélectionner l'évènement à suggérer dans l'onglet Évènements suggérés 
    $("div#sousform-lien_sig_contrainte_evenement select#evenement option[value='']").empty();
    $("div#sousform-lien_sig_contrainte_evenement select#evenement").chosen({
        width: "300px",
        placeholder_text_single: "Sélectionner un évènement",
        no_results_text: "Aucun résultat",
        allow_single_deselect: true
    });

    if (url.indexOf("index.php?module=form&obj=nature_travaux") != -1) {
        // Chosen multiple servant a sélectionner le dit dans nature de travaux
        $("div.form-content").parents("div.formEntete").css("overflow", "visible");
        $("select#dossier_instruction_type option[value='']").empty();
        $("select#dossier_instruction_type").chosen({
            width: "300px",
            placeholder_text_single: "Sélectionner les type de dossier d'instruction",
            no_results_text: "Aucun résultat",
            allow_single_deselect: true
        });
    }

    // Chosen servant à sélectionner l'évènement à suggérer dans l'onglet Évènements suggérés 
    $("div#sousform-lien_sig_contrainte_evenement select#evenement option[value='']").empty();
    $("div#sousform-lien_sig_contrainte_evenement select#evenement").chosen({
        width: "300px",
        placeholder_text_single: "Choisir l'événement",
        no_results_text: "Aucun résultat",
        allow_single_deselect: true
    });


    // Création d'un tooltip à coté de tous les champs Chosen 
    let chosenTitleText = "La chaîne de caractère de la barre de recherche doit figurer dans l'un des mots de l'élément désiré\nLa recherche n'est pas sensible à la casse.\nPar exemple, les premiers caractères saisis sont 'Ra':\n- 'Rapport d'annulation' apparaît puisque le mot 'RApport' contient les caractères saisis\n- 'Lettre rappel incomplétude' apparaît puisque le mot 'RAppel' contient les caractères saisis\n- 'Toutes les pièces du certificat d'urbanisme opérationnel' apparaît puisque le mot 'opéRAtionnel' contient les caractères saisis\n- 'Arrêté de conformité' n'apparaît pas puisqu'aucun des mots ne comporte les caractères saisis";

    if ($('div.chosen-container').has('.info-16.chosen-tooltip').length != 1) {
        $('div.chosen-container')
        .append('<span class="info-16 chosen-tooltip" title="'+chosenTitleText+'"></span>');
    }

    // Création d'une infobulle pour le champ json payload de la RA sur les moniteurs plat'au/ide'au 
    let json_payload_infobulle = "Vous devez utiliser les '*' au début et à la fin du terme que vous recherchez.\n Exemple pour une numéro de dossier : *PC 123456 12 12345* au lieu de PC 123456 12 12345 tout simplement.\n Un dernier exemple, les dates : *09/06/2022* au lieu de 09/06/2022.";

    $('label#lib-contenu_json')
        .append('<span class="info-16 " title="'+json_payload_infobulle+'"></span>');


    // Si le bouton de refresh de la preview existe sur la page, que celui-ci
    // est visible et que l'écran est considéré comme grand
    if ($('#btn_refresh').exists()
        && $('#btn_refresh').is(":visible")
        && screen.width > 1280) {
        // Récupère la position initiale du bouton
        btn_refresh_top = $('#btn_refresh').parent().offset().top-50
        // Le bonton suit le scroll de la page
        $(window).scroll(function (event) {
            if ($(window).scrollTop() > btn_refresh_top){
                $("#btn_refresh").addClass('floating');
            } else {
                $("#btn_refresh").removeClass('floating');
            }
        });
    }

    // Si le bouton pour afficher la prévisualisation existe et qu'il s'agit
    // d'un écran  considéré comme petit
    if ($('#btn_preview').exists() && (screen.width <= 1280 || $(window).width() <= 1266)) {
        // Récupère la position initiale du bouton
        btn_preview_top = $('#btn_preview').parent().offset().top-25
        // Le bonton suit le scroll de la page
        $(window).scroll(function (event) {
            if ($(window).scrollTop() > btn_preview_top){
                $("#btn_preview").css("position", "fixed");
                $("#btn_preview").css("top", 20);
                $("#btn_preview").css("z-index", 9999);
            } else {
                $("#btn_preview").css("position", "relative");
                $("#btn_preview").css("top", 0);
            }
        });
    }

   // Si le bouton pour afficher les champs de rédaction existe et qu'il s'agit
   // d'un écran considéré comme petit
   if ($('#btn_redaction').exists() && (screen.width <= 1280  || $(window).width() <= 1266)) {
        // Récupère la position initiale du bouton
       btn_redaction_top = $('#btn_redaction').parent().offset().top-25
       // Le bonton suit le scroll de la page
       $(window).scroll(function (event) {
           if ($(window).scrollTop() > btn_redaction_top){
                $("#btn_redaction").css("position", "fixed");
                $("#btn_redaction").css("top", 20);
                $("#btn_redaction").css("z-index", 9999);
            } else {
                $("#btn_redaction").css("position", "relative");
                $("#btn_redaction").css("top", 0);
            }
        });
   }

    // Depuis une instruction en modification, si la prévisualisation du PDF est
    // activée et que l'écran de l'utilisateur est considéré comme petit
    if ($(".container_instr_edition").exists() === true
        && (screen.width <= 1280  || $(window).width() <= 1266)) {
        //
        $(".preview_instr_edition").hide();
        //
        $("#btn_redaction").parent().parent().hide();
        $("#btn_refresh").parent().parent().hide();
    }
    // Sur un écran considéré comme grand
    if ($(".container_instr_edition").exists() === true
        && (screen.width > 1280 && $(window).width() > 1266)) {
        //
        $("#btn_preview").parent().parent().hide();
        $("#btn_redaction").parent().parent().hide();
    }

    // Si l'iframe de prévisualisation du PDF existe dans la page
    if ($(".preview_instr_edition .field-type-previsualiser_pdf #frame_content").exists() === true
        && $(".preview_instr_edition .field-type-previsualiser_pdf #frame_content").is (":visible")) {
        // Redimensionne la taille du contenu après un temps afin de laisser
        // tinymce calculer la taille des champs compléments
        setTimeout(resize_frame_pdf, 2000);
    }

    // masque par défaut les champs 'signataire' et 'type de rédaction' sur le
    // sous-formulaire d'ajout d'une instruction
    $('div.sousform-instruction-action-0 #flag_edition_integrale').parent().parent().hide();
    $('div.sousform-instruction-action-0 #signataire_arrete').parent().parent().hide();

    // modifie les messages de confirmations lors des clics sur les boutons du
    // Portlet 'Rédaction libre' et 'Rédaction par compléments'
    modify_confirm_msg_for_portlet_btn_redaction();
    //
    if ($('#sousform-document_numerise_preview_edition').exists() === true) {
        setTimeout(view_document_numerise_preview_edition, 500);
    } else if ($('#sousform-instruction_preview_edition').exists() === true) {
        setTimeout(view_instruction_preview_edition, 500);
    } else if ($('#sousform-rapport_instruction_preview_edition').exists() === true) {
        setTimeout(view_rapport_instruction_preview_edition, 500);
    } else if ($('#sousform-storage_preview_edition').exists() === true) {
        setTimeout(view_storage_preview_edition, 500);
    } else if ($('#sousform-consultation_preview_edition').exists() === true) {
        setTimeout(view_consultation_preview_edition, 500);
    }

    // Recherche de l'adresse dans la BAN avec présentation des résultats
    // dès l'ouverture du formulaire de normalisation
    if ($('#sousform-normalize_address').exists() === true) {
        search_geo_api_address();
        $("#address").autocomplete("search");
    }

    // récupère l'objet de l'url courante
    var obj = getUrlParamValue('obj', window.location.search);

    // si on est sur l'objet correspondant à une nouvelle demande
    if (obj == 'demande_nouveau_dossier' || obj == 'demande_nouveau_dossier_contentieux') {

        // ne pas afficher le champs de l'affectation automatique par défaut
        // sauf si une valeur est déjà sélectionnée
        var aff_auto_node = $('#affectation_automatique');
        if (aff_auto_node && aff_auto_node.val() == undefined || aff_auto_node.val() == '') {
            aff_auto_node.parent().parent().hide();
        }
    }
    // Le champ message_consultation_amenageur peut être affiché lors du lancement de la recherche d'opérateur.
    // Il faut donc vérifier si il existe et relancer la méthode permettant de cacher/afficher les champs.
    if ($("#operateur_amenagement_pers_publique").exists() || $("#message_consultation_amenageur").exists()) {
        switch_operateur_amenagement_pers_public($("#operateur_amenagement_pers_publique").val());
        $("select#operateur_amenagement_pers_publique").change(function() {
            switch_operateur_amenagement_pers_public($(this).val());
        });
        if ($("#operateur_pers_publique_amenageur").exists()) {
            switch_operateur_pers_publique_amenageur($("#operateur_pers_publique_amenageur").val());
            $("select#operateur_pers_publique_amenageur").change(function() {
                switch_operateur_pers_publique_amenageur($(this).val());
            });
        }
    }
}

/**
 * Recherche l'adresse normalisée dans l'API Adresse.
 *
 * @return void
 */
function search_geo_api_address() {
    $("#address").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "https://api-adresse.data.gouv.fr/search/?q="+$("#address").val(),
                data: { q: request.term },
                dataType: "json",
                success: function(data) {
                    response($.map(data.features, function(item) {
                        return {
                            label: item.properties.label,
                            properties: item.properties
                        };
                    }));
                }
            });
        },
        select: function(event, ui) {
            $('#address_json').val(JSON.stringify(ui.item.properties));
        }
    });
}

/**
 * Utilise l'action get_json_data du dossier pour
 * récupérer les informations du dossier. A partir de ces informations
 * compose l'adresse du terrain et fait appelle à la méthode
 * permettant de rediriger vers maps
 *
 * @return void
 */
function get_adresse_terrain(object, idDossierInstruction) {
    // Ajout d'un spinner d'attente
    $("#"+object).append(
        '<div class="msg_loading">'+msg_loading +'</div>'
    );
    //
    $.ajax({
        url: "../app/index.php?module=form&obj=dossier&idx="
            + idDossierInstruction
            + "&action=998",
        dataType: "json",
        success: function(data) {
            // Évite d'avoir des espaces inutiles si des morceaux de l'adresse
            // n'ont pas été rempli ou si l'adresse est vide
            adresse = '';
            adresse = data.terrain_adresse_voie_numero != '' ?
                adresse + data.terrain_adresse_voie_numero : adresse;
            adresse = data.terrain_adresse_code_postal != '' ?
                adresse + ' ' + data.terrain_adresse_code_postal : adresse;
            adresse = data.terrain_adresse_voie != '' ?
                adresse + ' ' + data.terrain_adresse_voie : adresse;
            adresse = data.terrain_adresse_localite != '' ?
                adresse + ' ' + data.terrain_adresse_localite : adresse;
                open_streetview(adresse);
        }
    });
    // Suppression du spinner d'attente
    $("#"+object+" .msg_loading").remove();
}

/**
 * Envoie l'adresse reçu à la BAN pour récupérer sa latitude et sa longitude
 * puis compose l'url vers google map en utilisant ces données.
 * Si l'adresse récupérée est vide ou si l'adresse n'a pas été trouvé par la BAN
 * ouvre google map sans localisation, sinon ouvre google map en mode streetview
 * vers l'adresse indiquée.
 *
 * @return string
 */
function open_streetview(adresse) {
    if (adresse != '') {
        $.ajax({
            url: "https://api-adresse.data.gouv.fr/search/?q="+ adresse,
            dataType: "json",
            success: function(data) {
                coordonne = $.map(data.features, function(item) {
                    return {
                        coordinates : item.geometry.coordinates
                    };
                });

                // Composition du lien streetview. Si aucune adresse n'a été récupéré alors
                // redirige vers google maps sans envoyer d'adresse.

                // Utilise les coordonées récupérées comme paramètre pour l'URL
                parametreUrl = '';
                if (coordonne.length > 0
                    && $.inArray('coordinates', coordonne)
                    && coordonne[0]['coordinates'].length >= 2) {
                    //
                    parametreUrl = 
                        '?q=&layer=c&cbll='
                        + encodeURIComponent(
                            coordonne[0]['coordinates'][1]
                            + ','
                            + coordonne[0]['coordinates'][0]
                    );
                }
    
                urlStreetview = "https://www.google.com/maps" + parametreUrl;
                window.open(urlStreetview);
            }
        });
    } else {
        window.open("https://www.google.com/maps");
    }
}

/**
 * Appel la méthode PHP pour mettre à jour les données de l'adresse normalisée
 * et recharge la page pour avoir les valeurs de la synthèse du dossier à jour.
 *
 * @param  object form Formulaire de normalisation de l'adresse
 * @return void
 */
function normalize_address(form) {
    $.ajax({
        type: "POST",
        url: form.firstElementChild.attributes["data-href"].value,
        cache: false,
        data: "address="+form.elements["address"].value+"&address_json="+form.elements["address_json"].value+"&submit-normalize="+form.elements["submit-normalize"].value,
        success: function(html){
            refresh_page_return();
        }
    });
}

/**
 * Depuis une instruction en modification avec l'option de prévisualisation
 * activée, affiche le contexte de la prévisualisation.
 *
 * @return void
 */
function show_instr_preview() {
    $(".redaction_instr_edition").hide();
    $(".preview_instr_edition").show();
    //
    $("#btn_preview").parent().parent().hide();
    $("#btn_redaction").parent().parent().show();
    //
    reload_pdf_viewer();
}

/**
 * Depuis une instruction en modification avec l'option de prévisualisation
 * activée, affiche le contexte de la rédaction.
 *
 * @return void
 */
function show_instr_redaction() {
    $(".redaction_instr_edition").show();
    $(".preview_instr_edition").hide();
    //
    $("#btn_preview").parent().parent().show();
    $("#btn_redaction").parent().parent().hide();
    //
    $(window).scrollTop($(".container_instr_edition").offset().top);
}


function activate_data_href() {
    $('#sousform-href-disabled').attr('id', 'sousform-href');
}

jQuery.fn.exists = function(){return this.length>0;}

// Retourne la valeur d'une variable GET de l'URL
function getQuerystring(key, default_)
{
  if (default_==null) default_="";
  key = key.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regex = new RegExp("[\\?&]"+key+"=([^&#]*)");
  var qs = regex.exec(window.location.href);
  if(qs == null)
    return default_;
  else
    return qs[1];
}

/**
 * Fonction permettant de faire la somme des champs passé en 2nd parametre et
 * le stocker dans le champ passé en 1er
 */
function sommeChampsCerfa(cible, source) {
    val_cible = 0;
    
    $.each(source, function(index, value) {
        // Conversion des champs source en integer
        val_source = parseInt($('#'+value).val());
        // Cumul des valeurs des champs source
        val_cible = val_cible + (isNaN(val_source) ? 0 : val_source);
    });
    // Affectation de la nouvelle valeur
    $('#'+cible).val(val_cible);
}


/**
 * Calcul automatique des tableaux des surfaces.
 *
 * @param integer tab Numéro du tableau des surface (1 pour les destinations, 2
 * pour les sous-destinations).
 *
 * @return void
 */
function calculSurfaceTotal(tab) {

    // On vérifie que le paramètre fait référence à un des tableaux
    if (tab !== 1 && tab !== 2) {
        return;
    }

    // Préfixe des champs du tableau
    var prefix;
    // Nom des colonnes du tableau
    var nom_col;
    // Nombre de ligne du tableau
    var nb_ligne;

    // Tableau des destinations
    if (tab === 1) {
        //
        prefix = "su"
        //
        nom_col = [ "su_avt_shon",
                    "su_cstr_shon",
                    "su_chge_shon",
                    "su_demo_shon",
                    "su_sup_shon",
                    "su_tot_shon" ];
        //
        nb_ligne = 9;
    }

    // Tableau des sous-destinations
    if (tab === 2) {
        //
        prefix = "su2"
        //
        nom_col = [ "su2_avt_shon",
                    "su2_cstr_shon",
                    "su2_chge_shon",
                    "su2_demo_shon",
                    "su2_sup_shon",
                    "su2_tot_shon" ];
        //
        nb_ligne = 22;
    }

    // Calcul des totaux de colonnes
    $.each(nom_col, function(index, value) {
        var tot_col = 0;
        for ( var i = 1; i <= nb_ligne; i++ ) {
            // Conversion des champs source en numérique flotant
            val_source = parseFloat($('#'+value+i).val());
            val_source = parseFloat(val_source.toFixed(2));
            if (isNaN(val_source) == false) {
                $('#'+value+i).val(val_source);
            }
            // Cumul des valeurs des champs source
            tot_col = tot_col + (isNaN(val_source) ? 0 : val_source);
        }

        // Affectation du résultat de ligne
        $('#'+value+'_tot').val(tot_col);
    });

    // Calcul des totaux des lignes
    for ( var j = 1; j <= nb_ligne; j++ ) {
        // Conversion des champs source en numérique flotant
        su_avt_shon = parseFloat($('#'+prefix+'_avt_shon'+j).val());
        if (isNaN(su_avt_shon) == false) {
            su_avt_shon = parseFloat(su_avt_shon.toFixed(2));
            $('#'+prefix+'_avt_shon'+j).val(su_avt_shon);
        }
        su_cstr_shon = parseFloat($('#'+prefix+'_cstr_shon'+j).val());
        if (isNaN(su_cstr_shon) == false) {
            su_cstr_shon = parseFloat(su_cstr_shon.toFixed(2));
            $('#'+prefix+'_cstr_shon'+j).val(su_cstr_shon);
        }
        su_chge_shon = parseFloat($('#'+prefix+'_chge_shon'+j).val());
        if (isNaN(su_chge_shon) == false) {
            su_chge_shon = parseFloat(su_chge_shon.toFixed(2));
            $('#'+prefix+'_chge_shon'+j).val(su_chge_shon);
        }
        su_demo_shon = parseFloat($('#'+prefix+'_demo_shon'+j).val());
        if (isNaN(su_demo_shon) == false) {
            su_demo_shon = parseFloat(su_demo_shon.toFixed(2));
            $('#'+prefix+'_demo_shon'+j).val(su_demo_shon);
        }
        su_sup_shon = parseFloat($('#'+prefix+'_sup_shon'+j).val());
        if (isNaN(su_sup_shon) == false) {
            su_sup_shon = parseFloat(su_sup_shon.toFixed(2));
            $('#'+prefix+'_sup_shon'+j).val(su_sup_shon);
        }
        
        // Cumul des valeurs des champs source
        su_avt_shon = isNaN(su_avt_shon) ? 0 : su_avt_shon;
        su_cstr_shon = isNaN(su_cstr_shon) ? 0 : su_cstr_shon;
        su_chge_shon = isNaN(su_chge_shon) ? 0 : su_chge_shon;
        su_demo_shon = isNaN(su_demo_shon) ? 0 : su_demo_shon;
        su_sup_shon = isNaN(su_sup_shon) ? 0 : su_sup_shon;

        // Affectation du résultat de ligne
        su_tot_shon = (su_avt_shon+su_cstr_shon+su_chge_shon)-(su_demo_shon+su_sup_shon);
        su_tot_shon = parseFloat(su_tot_shon.toFixed(2));
        $('#'+prefix+'_tot_shon'+j).val(su_tot_shon);

    }

    // Calcul du total des totaux
    // Conversion des champs source en numérique flotant
    su_avt_shon = parseFloat($('#'+prefix+'_avt_shon_tot').val());
    su_avt_shon = parseFloat(su_avt_shon.toFixed(2));
    if (isNaN(su_avt_shon) == false) {
        su_avt_shon = parseFloat(su_avt_shon.toFixed(2));
        $('#'+prefix+'_avt_shon_tot').val(su_avt_shon);
    }
    su_cstr_shon = parseFloat($('#'+prefix+'_cstr_shon_tot').val());
    su_cstr_shon = parseFloat(su_cstr_shon.toFixed(2));
    if (isNaN(su_cstr_shon) == false) {
        su_cstr_shon = parseFloat(su_cstr_shon.toFixed(2));
        $('#'+prefix+'_cstr_shon_tot').val(su_cstr_shon);
    }
    su_chge_shon = parseFloat($('#'+prefix+'_chge_shon_tot').val());
    su_chge_shon = parseFloat(su_chge_shon.toFixed(2));
    if (isNaN(su_chge_shon) == false) {
        su_chge_shon = parseFloat(su_chge_shon.toFixed(2));
        $('#'+prefix+'_chge_shon_tot').val(su_chge_shon);
    }
    su_demo_shon = parseFloat($('#'+prefix+'_demo_shon_tot').val());
    su_demo_shon = parseFloat(su_demo_shon.toFixed(2));
    if (isNaN(su_demo_shon) == false) {
        su_demo_shon = parseFloat(su_demo_shon.toFixed(2));
        $('#'+prefix+'_demo_shon_tot').val(su_demo_shon);
    }
    su_sup_shon = parseFloat($('#'+prefix+'_sup_shon_tot').val());
    su_sup_shon = parseFloat(su_sup_shon.toFixed(2));
    if (isNaN(su_sup_shon) == false) {
        su_sup_shon = parseFloat(su_sup_shon.toFixed(2));
        $('#'+prefix+'_sup_shon_tot').val(su_sup_shon);
    }

    // Cumul des valeurs des champs source
    su_avt_shon = isNaN(su_avt_shon) ? 0 : su_avt_shon;
    su_cstr_shon = isNaN(su_cstr_shon) ? 0 : su_cstr_shon;
    su_chge_shon = isNaN(su_chge_shon) ? 0 : su_chge_shon;
    su_demo_shon = isNaN(su_demo_shon) ? 0 : su_demo_shon;
    su_sup_shon = isNaN(su_sup_shon) ? 0 : su_sup_shon;

    // Affectation du résultat de ligne
    su_tot_shon_tot = (su_avt_shon+su_cstr_shon+su_chge_shon)-(su_demo_shon+su_sup_shon);
    su_tot_shon_tot = parseFloat(su_tot_shon_tot.toFixed(2));
    $('#'+prefix+'_tot_shon_tot').val(su_tot_shon_tot);

}

/*
 * Marque comme non frequent un petitionnaire
 */
function portletUpdatePetitionnaire(id, objet, objetc, file, field, message){
    
    /*
     *Vérifie que l'identifiant passé en paramètre est bien un chiffre
     * et que le type d'objet est défini
     */
    if ( $.isNumeric(id) && objet != '' ){
        
        donnees = "?ido=" + id + '&obj=' + objet + '&objk=' + objetc + '&idxDossier=' + getQuerystring('idx');
        $.ajax({
            type: "GET",
            url: "../app/"+file+".php" + donnees ,
            cache: false,
            success: function(html){
                
                $('#formulaire .message').remove();
                /*Change la valeur affiché et affiche un message valide*/
                if ( $.parseJSON(html) == "Mise à jour effectué avec succès" || 
                $.parseJSON(html).indexOf("Transfert effectue avec succes") != -1 ){
                    
                    // On modife le champ field
                    if ( field != '' && message != '' ){
                        $('#'+field).html(message);
                        html = $.parseJSON(html);
                    }
                    else {
                        html = $.parseJSON(html).split(';');
                        
                        $('#'+field).html(html[0]);
                        
                        html = html[1];
                    }
                    
                    // On supprime l'action
                    $('span.'+field+'-16').parent().parent().remove();
                    // On affiche le message
                    $('#formulaire #tabs-1').prepend(
                        '<div ' +
                            'class="message ui-widget ui-corner-all ui-state-highlight ui-state-valid">' +
                            '<p>' +
                                '<span class="ui-icon ui-icon-info"></span>' +
                                '<span class="text">' +
                                    html +
                                '</span>' +
                            '</p>' +
                        '</div>'
                    );
                }
                /*Affichage d'une erreur*/
                else{
                    $('#formulaire #tabs-1').prepend(
                        '<div ' +
                            'class="message ui-widget ui-corner-all ui-state-highlight ui-state-error">' +
                            '<p>' +
                                '<span class="ui-icon ui-icon-info"></span>' +
                                '<span class="text">' +
                                    $.parseJSON(html) +
                                '</span>' +
                            '</p>' +
                        '</div>'
                    );
                }
            }
        });
    }
}


// Affiche le sous formulaire onglet
function redirectPortletAction(id, onglet, nom_tabs){

    var nom_tabs =  ( typeof nom_tabs === "undefined" ) ? ".ui-tabs" : nom_tabs;
    var $tabs = $(nom_tabs).tabs(); 

    lien_onglet = $('#' + onglet).attr('href');
    lien_onglet = lien_onglet.substring( lien_onglet.length - 1, lien_onglet.length);

    $tabs.tabs('select', lien_onglet); 
}

/**
 * COMMISSION
 */
// Gestion de l'interface de gestion de la commission
function commission_manage_interface() {
    // Gestion des onglets
    var $tabs = $("#commission-manage-tabs").tabs({
        load: function(event, ui) {
            //
            om_initialize_content(true);
            return true;
        },
        select: function(event, ui) {
            // Suppression du contenu de l'onglet precedemment selectionne
            // #ui-tabs-X correspond uniquement aux ids des onglets charges
            // dynamiquement
            selectedTabIndex = $tabs.tabs('option', 'selected');
            $("#ui-tabs-"+(selectedTabIndex+1)).empty();
            return true;
        },
        ajaxOptions: {
            error: function(xhr, status, index, anchor) {
                $(anchor.hash).html(msg_alert_error_tabs);
            }
        }
    });
}
// Gestion spécifique de la soumission du formulaire qui contient des checkbox
// et qui est soumis via une requête Ajax. Il n'est pas possible de savoir
// quelles checkbox sont cochées, elles sont toutes renvoyées.
// On compose donc un champ particulier représentant les cases cochées
// avant de poster le formulaire.
function commission_submit_plan_or_unplan_demands(objsf, link, formulaire) {
    //
    $("#view_form_plan_or_unplan_demands .message").remove();
    $("#view_form_plan_or_unplan_demands").prepend(
        '<div class="msg_loading">'+msg_loading +'</div>'
    );
    //
    var checkeds = '';
    $("#view_form_plan_or_unplan_demands form input[type='checkbox']").each(
        function(index) {
            if ($(this).is(":checked")) {
                checkeds += $(this).val()+";";
            }
        }
    );
    //
    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "checkeds";
    input.value = checkeds;
    formulaire.appendChild(input);
    //
    affichersform(objsf, link, formulaire);
    //
    $("#view_form_plan_or_unplan_demands .msg_loading").remove();
}
// Aide à la saisie, récupère les données du type de commission et pré-remplit
// les champs de la commission
function commission_update_data_from_commission_type(commission_type_id){
    // Requête ajax de récupération des données
    $.ajax({
        type: "GET",
        url: "../app/index.php?module=form&obj=commission_type&action=11&idx="+commission_type_id,
        dataType: "json",
        async: false,
        success: function(data){
            // Ajout des données dans les champs
            $('#libelle').val(data.libelle);
            $('#lieu_adresse_ligne1').val(data.lieu_adresse_ligne1);
            $('#lieu_adresse_ligne2').val(data.lieu_adresse_ligne2);
            $('#lieu_salle').val(data.lieu_salle);
            $('#listes_de_diffusion').val(data.listes_de_diffusion);
            $('#participants').val(data.participants);
        }
    });
}

/**
 * Popup de confirmation pour les traitements
 */
//
function trt_confirm() {
    //
    if (confirm("Etes-vous sur de vouloir confirmer cette action ?")) {
        //
        return true;
    } else {
        //
        return false;
    }
}

/**
 * Cette fonction permet d'afficher les options d'un select par rapport
 * à un autre champ
 * 
 * @param  int id               Données (identifiant) du champ visé
 * @param  string tableName     Nom de la table
 * @param  string linkedField   Champ visé
 * @param  string formCible     Formulaire visé
 */
function filterSelect(id, tableName, linkedField, formCible) {

    //lien vers script php
    link = "../app/index.php?module=form&snippet=filterselect&idx=" + id + "&tableName=" + tableName +
            "&linkedField=" + linkedField + "&formCible=" + formCible;

    $.ajax({
        type: "GET",
        url: link,
        cache: false,
        dataType: "json",
        success: function(res){
            //
            $('#'+tableName).empty();
            //
            for ( j=0 ; j < res[0].length ; j++ ){
                //
                $('#'+tableName).append(
                    '<option value="'+res[0][j]+'" >'+res[1][j]+'</option>'
                );
            }
        },
        async: false
    });
}

/**
 * Redirige vers une page après un temps d'attente
 * @param  string   page            lien de la page vers la redirection
 * @param  int      milliseconde    temps d'attente avant la redirection
 */
function redirection(page, milliseconde) {

    //
    setTimeout(window.location = page, milliseconde);
}

/**
 * Retourne ce qu'il y a à afficher dans le formulaire de retour (bouton ajouter ou supprimer et éditer)
 */
function getObjId(obj){

    //Récupération de l'id de l'objet
    var id=$('#id_retour').val();

    //Retour des données
    if ( $('#id_retour').length > 0 ){
        setDataFrequent(id, obj);
        om_initialize_content();
    }
}

function setDataFrequent(id,obj) {
    $.ajax({
        type: "GET",
        url: '../app/afficher_synthese_obj.view.php?idx='+id+'&obj=' + obj,
        cache: false,
        success: function(html){
            $('.add_'+obj).each(
                function(){
                    $(this).remove();
                }
            );
            $(html).insertBefore('#'+obj).fadeIn(500);
            $('#'+obj).val(id);
        },
        async:false
    });
}

/**
 * Redirige vers le script PHP pour mettre à jour les informations
 * et met à jour l'interface pour l'utilisateur
 * @param  string   obj             Objet du dossier
 * @param  string   id              Identifiant du dossier
 * @param  string   fieldname       Nom du champ
 * @param  Function callback        Fonction mettant à jour l'interface des données
 * @param  string   confirm_message Texte du message de confirmation
 */
function geolocalisation_treatment(obj, id, fieldname, callback, confirm_message) {

    var idx_dossier = id;
    // Overlay de confirmation du traitement
    if (confirm_message != null && confirm_message != '') {
        var dialog_confirm = confirm(confirm_message);
        if( dialog_confirm == false ){
          return false;
        }
    }

    // Affichage du spinner
    $('#'+fieldname).each(
        function(){
            $(this).children().removeClass();
            $(this).children().addClass('message ui-widget ui-corner-all ui-state-highlight ui-state-empty');
            $(this).children().children().children(".text").html(msg_loading);
        }
    );
    
    // lien vers script PHP faisant l'appel au webservice
    link = '../app/index.php?module=form&obj=' + obj + '&idx='+id+'&action=';
    // sélection de l'action en fonction du bouton cliqué
    switch(fieldname) {
        case 'verif_parcelle':
            link += '121';
            break;
        case 'calcul_emprise':
            link += '122';
            break;
        case 'dessin_emprise':
            link += '123';
            break;
        case 'calcul_centroide':
            link += '124';
            break;
        case 'recup_contrainte':
            link += '125';
            break;
    } 

    // Traitement
    $.ajax({
        type: "GET",
        url: link,
        cache: false,
        dataType: "json",
        success: function(res){
            //
            $('#'+fieldname).each(
                function(){
                    // Affichage du message en face de l'action
                    $(this).children().children().children(".text").text(res['log']['message']);
                    $(this).children().removeClass();
                    // Changement de la couleur du message selon la réponse de
                    // l'action
                    if (res['log']['etat'] == true) {
                        $(this).children().addClass('message ui-widget ui-corner-all ui-state-highlight ui-state-valid');
                    } else {
                        $(this).children().addClass('message ui-widget ui-corner-all ui-state-highlight ui-state-error');
                    }
                }
            );

            // Appel de la méthode de callback si l'action s'est déroulée correctement
            if (typeof(callback) === "function" && res['log']['etat'] == true) {
                callback(res, idx_dossier);
            }
        },
        async:false
    });
}

/**
 * Efface le message en haut du formulaire
 * @param array res Résultat après le traitement du script PHP
 */
function set_geolocalisation_message(res, id) {
    // Si il y a un message d'erreur
    if ($('#geolocalisation-message')[0]) {
        // Supprime le message
        $('#geolocalisation-message').remove();
        // Modifie les messages des autres fonctionnalités
        $('#calcul_emprise').each(
            function() {
                $(this).children().removeClass();
                $(this).children().addClass('message ui-widget ui-corner-all ui-state-highlight ui-state-error');
                $(this).children().children().children(".text").text(res['log']['message_diff_parcelle']);
            }
        );
        $('#calcul_centroide').each(
            function() {
                $(this).children().removeClass();
                $(this).children().addClass('message ui-widget ui-corner-all ui-state-highlight ui-state-error');
                $(this).children().children().children(".text").text(res['log']['message_diff_parcelle']);
            }
        );
        $('#recup_contrainte').each(
            function() {
                $(this).children().removeClass();
                $(this).children().addClass('message ui-widget ui-corner-all ui-state-highlight ui-state-error');
                $(this).children().children().children(".text").text(res['log']['message_diff_parcelle']);
            }
        );
    }
    
}

/**
 * Met le champ centroïde à jour
 * @param  array   res	Résultat après le traitement du script PHP
 */
function set_geolocalisation_centroide(res, id) {
    var content = "<a id='action-form-localiser'"+
            " target='_SIG' href='../app/index.php?module=form&obj=dossier_instruction&action=140&idx="+id+"'>"+
            "<span class='om-icon om-icon-16 om-icon-fix sig-16' title='Localiser'>Localiser</span> "+
            " POINT("+res['return']['x']+" "+res['return']['y']+")"+
            " </a>";
    
    $('span#centroide').html(content);
}

/**
 * Met le champ contrainte à jour
 * @param  array   res	Résultat après le traitement du script PHP
 */
function set_geolocalisation_contrainte(res, id) {
    // Contenus du champ contrainte
    var content = $('span#msg_contrainte_sig').html();
    // Si aucune contraintes est récupérées du SIG
    if (res['dossier_contrainte']['nb_contrainte_sig'] == 0) {
        content = res['dossier_contrainte']['msg_contrainte_sig_empty'];
    }
    // S'il y a des contraintes récupérées
    if (res['dossier_contrainte']['nb_contrainte_sig'] != 0) {
        content = res['dossier_contrainte']['nb_contrainte_sig'] + " " + res['dossier_contrainte']['msg_contrainte_sig']
    }
    // Affiche le message
    $('span#msg_contrainte_sig').html(content);
}

/**
 * Redirige vers le sig
 * @param array res Résultat après le traitement du script PHP
 */
function redirection_web_sig(res, id) {
    window.open(res['return']);
}

/**
 * Traitement du bouton permettant de calculer toutes les données géographiques
 * @param  string   obj                 Objet du dossier
 * @param  string   id                  Identifiant du dossier
 * @param  string   confirm_message     Texte du message de confirmation
 */
function all_geolocalisation_treatments(obj, id, confirm_message) {

    // Overlay de confirmation du traitement
    if (confirm_message != null && confirm_message != '') {
        var dialog_confirm = confirm(confirm_message);
        if( dialog_confirm == false ){
          return false;
        }
    }

    // Initialisation des variables utilisées en paramètres
    var fieldname = '';
    var callback = '';
    var confirm_message = '';
    var flag = '';

    // Modification des variables utilisées en paramètres pour "Vérifier les
    // parcelles"
    fieldname = 'verif_parcelle';
    callback = set_geolocalisation_message;
    // Traitement "Vérifier les parcelles"
    geolocalisation_treatment(obj, id, fieldname, callback, confirm_message);

    // Positionne le flag sur le message de "Vérifier les parcelles"
    flag = $('#'+fieldname+"-message").attr("class");
    // Si c'est un message d'erreur on arrete le traitement
    if (flag == 'message ui-widget ui-corner-all ui-state-highlight ui-state-error') {
        return false;
    }

    // Modification des variables utilisées en paramètres pour "Calculer 
    // l'emprise"
    fieldname = 'calcul_emprise';
    callback = '';
    // Traitement "Calculer l'emprise"
    geolocalisation_treatment(obj, id, fieldname, callback, confirm_message);

    // Positionne le flag sur le message de "Calculer l'emprise"
    flag = $('#'+fieldname+"-message").attr("class");
    // Si c'est un message d'erreur on arrete le traitement
    if (flag == 'message ui-widget ui-corner-all ui-state-highlight ui-state-error') {
        return false;
    }

    // Modification des variables utilisées en paramètres pour "Calculer le 
    // centroïde"
    fieldname = 'calcul_centroide';
    callback = set_geolocalisation_centroide;
    // Traitement "Calculer le centroïde"
    geolocalisation_treatment(obj, id, fieldname, callback, confirm_message);

    // Positionne le flag sur le message de "Calculer le centroïde"
    flag = $('#'+fieldname+"-message").attr("class");
    // Si c'est un message d'erreur on arrete le traitement
    if (flag == 'message ui-widget ui-corner-all ui-state-highlight ui-state-error') {
        return false;
    }

    // Modification des variables utilisées en paramètres pour "Récupérer les
    // contraintes"
    fieldname = 'recup_contrainte';
    callback = set_geolocalisation_contrainte;
    //Traitement "Récupérer les contraintes"
    geolocalisation_treatment(obj, id, fieldname, callback, confirm_message);
    
}

/**
 * Remplit le formulaire avec l'adresse trouvée ou affiche un message d'erreur
 */
function getAdressFromCadastrale(){
    
    //Récupération des références cadastrales
    var referenceCadastrale = '{"refcad":[{';
    var i = 0 ;
    var j = 1 ;
    var delimit = 0;
    var parcelleDelimit = 0;
    var noReferenceCadastrale = false;
    var om_collectivite = "";
    if($("#om_collectivite").attr("type") != "hidden") {
        om_collectivite = $("#om_collectivite").val();
        if(om_collectivite == '') {
            alert('Une collectivité doit être sélectionnée');
            return;
        }
    }
    var commune_node = document.getElementById('commune');
    if (! commune_node) {
        commune_node = document.getElementById('autocomplete-commune-id');
    }
    $(".reference_cadastrale_custom_field").each(
        function(){
            
            //On vérifie que le champ n'est pas vide
            if ($(this).val()!=""&&$(this).val() != ";"){
                noReferenceCadastrale = true;
            }
            
            //On va à la ligne suivante
            if ( $(this).val() == ";" ){
                referenceCadastrale +=(delimit!=0)?'}]':''; 
                referenceCadastrale += "}" ;
                i++;
                j = 1;
                delimit = 0;
                parcelleDelimit = 0;
            }
            //On parcourt la ligne
            else {
                switch(true){
                    //Quartier
                    case (j==1):
                        referenceCadastrale += (i!=0)?',':'';
                        referenceCadastrale += '"' + i + '"' + ':{"quartier":"'+$(this).val()+'"';
                        break;
                    //Section
                    case (j==2):
                        referenceCadastrale += ', "section":"'+$(this).val()+'"';
                        break;
                    //Parcelle
                    case (j==3):
                        referenceCadastrale += ', "parcelle":"'+$(this).val()+'"';
                        break;
                    //Le délimiteur
                    case (j%2==0&&j!=2):
                        if ( delimit==0 ){
                            referenceCadastrale += ', "delimit":[{"'+(delimit++)+'":"'+$(this).val()+'"';
                        }
                        else {
                            referenceCadastrale += ', "'+(delimit++)+'":"'+$(this).val()+'"';
                        }
                        break;
                    //La parcelle après le délimiteur
                    case (j%2==1&&j!=1&&j!=3):
                        referenceCadastrale += ',"'+(delimit++)+'":"'+$(this).val()+'"';
                        break;
                }
                j++;
            }
        }
    );
    if ( noReferenceCadastrale == true ){
        referenceCadastrale += "}]";
        if(om_collectivite != "") {
            referenceCadastrale += ', "om_collectivite":'+om_collectivite;
        }
        if (commune_node) {
            referenceCadastrale += ', "commune":'+commune_node.value;
        }
        referenceCadastrale += "}";
    }
    else {
        referenceCadastrale = "";
    }
    // Lien
    link = "../app/index.php?module=form&obj=demande&action=130&idx=0";
    // Affichage du spinner
    ;
    $('#cad-adr-them').parent().append('<img id="adresse_cadastral_spinner" src="../lib/om-assets/img/loading.gif" alt="Le traitement est en cours. Merci de patienter.">');
    //Lance la tentative de récupération de l'adresse
    $.ajax({
        type: "POST",
        url: link,
        data: $.parseJSON(referenceCadastrale),
        cache: false,
        dataType: "json",
        success: function(data){
            //Si le retour est un objet JSON, on a un résultat
            if ( $.isPlainObject(data)){
                
                //On met l'adresse dans les champs
                $("#terrain_adresse_voie_numero").val(data.return_addr.numero_voie);
                $("#terrain_adresse_voie").val(data.return_addr.nom_voie);
                $("#terrain_adresse_code_postal").val(data.return_addr.code_postal);
                $("#terrain_adresse_localite").val(data.return_addr.localite);
            }
            //Sinon, on affiche un message d'erreur
            else {
                alert(data);
            }
            $('#adresse_cadastral_spinner').remove();
        },
        async: false
    });
}

/**
 * Modifie les champs requis pour le formulaire demande_type
 * @param  integer  demande_nature                         Identifiant
 * @param  string   lib_dossier_autorisation_type_detaille Libellé du champ
 * dossier_autorisation_type_detaille
 * @param  string   lib_dossier_instruction_type           Libellé du champ
 * dossier_instruction_type
 */
function required_fields_demande_type(demande_nature, lib_dossier_autorisation_type_detaille, lib_dossier_instruction_type) {

    // Lien
    link = "../app/index.php?module=form&obj=demande_nature&action=11&idx=" + demande_nature;

    // Traitement
    $.ajax({
        type: "GET",
        url: link,
        cache: false,
        dataType: "json",
        success: function(demande_nature_info) {

            // On enlève le "*" au libellé du champ 
            // dossier_autorisation_type_detaille pour montrer qu'il n'est 
            // pas obligatoire
            $("#lib-dossier_autorisation_type_detaille").text('');
            $("#lib-dossier_autorisation_type_detaille")
                .html(lib_dossier_autorisation_type_detaille);

            // On enlève le "*" au libellé du champ 
            // dossier_instruction_type pour montrer qu'il n'est 
            // pas obligatoire
            $("#lib-dossier_instruction_type").text('');
            $("#lib-dossier_instruction_type")
                .html(lib_dossier_instruction_type);
            
            // Si c'est une nouvelle demande
            if (demande_nature_info != ''
                && demande_nature_info != null) {

                if (demande_nature_info['code'] == 'NOUV') {

                    // On ajoute le "*" au libellé du champ 
                    // dossier_autorisation_type_detaille pour montrer qu'il est 
                    // obligatoire
                    $("#lib-dossier_autorisation_type_detaille").text('');
                    $("#lib-dossier_autorisation_type_detaille")
                        .html(lib_dossier_autorisation_type_detaille + ' <span class="not-null-tag">*</span>');

                    // On ajoute le "*" au libellé du champ 
                    // dossier_instruction_type pour montrer qu'il est 
                    // obligatoire
                    $("#lib-dossier_instruction_type").text('');
                    $("#lib-dossier_instruction_type")
                        .html(lib_dossier_instruction_type + ' <span class="not-null-tag">*</span>');

                } 

            }
            
        },
        async:false
    });
}

/**
 * Appel au chargement de la page
 **/
$(function() {

    // url de la page
    url = document.location + "";

    // Si dans le formulaire des type de demande
    // et que c'est en mode ajout ou modifier
    if (url.indexOf("index.php?module=form&obj=demande_type&") != -1
        && (url.indexOf("&action=0") != -1
        || url.indexOf("&action=1") != -1
        || url.indexOf("&validation=") != -1)) {

        // Récupère les paramètres nécessaires
        var demande_nature = $("#demande_nature").val();
        var lib_dossier_autorisation_type_detaille = $("#lib-dossier_autorisation_type_detaille").text();
        var lib_dossier_instruction_type = $("#lib-dossier_instruction_type").text();

        // Appelle la fonction pour indiquer si les champs sont requis ou non
        required_fields_demande_type(demande_nature, lib_dossier_autorisation_type_detaille, lib_dossier_instruction_type);
    }

    // Bind les widgets RSS affichés sur le tableau de bord
    bind_widget_rss();
});

/**
 * Cache les champs du formulaire événement
 * @param  array fields Tableau des champs
 */
function hideFieldsEvenement(fields) {

    // Pour chaque champ
    for (var cpt = 0; cpt < fields.length; cpt++) {

        $('#' + fields[cpt]).each(
            function(){

                // Récupère la balise parent et la valeur
                var parentField = $(this).parent();
                var valueField = $(this).val();
                // Supprime le champ
                $(this).remove();
                // Affiche le champ en tant que static
                parentField.append('<span id="'+fields[cpt]+'" class="field_value">'+valueField+'</span>');
            }
        );

    }
    
    // Cache les champs "evenement_retour_ar" et "evenement_retour_signature"
    $('#evenement_retour_ar').parent().parent().hide();
    $('#evenement_retour_signature').parent().parent().hide();
}

/**
 * Affiche les champs du formulaire événement
 * @param  array fields Tableau des champs
 */
function showFieldsEvenement(fields) {

    // Pour chaque champ
    for (var cpt = 0; cpt < fields.length; cpt++) {

        $('#' + fields[cpt]).each(
            function(){

                // Récupère la balise parent et la valeur
                var parentField = $(this).parent();
                var valueField = $(this).text();
                // Supprime le champ
                $(this).remove();

                // Si le champ est restriction
                if (this.id == 'restriction') {

                    // Réaffiche le champ en type text
                    parentField.append('<input id="'+this.id+'" class="champFormulaire" type="text" maxlength="60" size="30" value="'+ valueField +'" name="'+this.id+'">');
                } else {

                    // Réaffiche les selects
                    parentField.append('<select id="'+this.id+'" class="champFormulaire" size="1" name="'+this.id+'"></select>');
                    filterSelect(valueField, fields[cpt], 'delai', 'evenement');
                }
            }
        );

    }

    // Affiche les champs "evenement_retour_ar" et "evenement_retour_signature"
    $('#evenement_retour_ar').parent().parent().show();
    $('#evenement_retour_signature').parent().parent().show();
}

/**
 * Action onchange sur la case à cocher "retour" du formulaire "evenement"
 * @param  object field Champ de type booléen
 */
function retourOnchangeEvenement(field) {

    // liste des champs à modifier dans le formulaire
    var fields = new Array(
        'restriction', 
        'delai', 
        'accord_tacite', 
        'delai_notification', 
        'avis_decision'
    );

    // Si le champ booléen est à 'Oui'
    if (field.value == 'Oui') {
        // Cache et rend static les champs de la liste
        hideFieldsEvenement(fields);
    } else {
        // Affiche et rend modifiable les champs de la liste
        showFieldsEvenement(fields);
    }
}

/**
 * Permet de récupérer les contraintes ajoutées manuellement depuis le
 * formulaire spécifique.
 */
function dossierContrainteValidationForm(objsf, link, formulaire) {
    // composition de la chaine data en fonction des elements du formulaire
    var data = "";
    //
    if (formulaire) {
        // Pour chaque champ du formulaire
        for (i=0; i<formulaire.elements.length; i++) {
            //
            var name = formulaire.elements[i].name;  
            var value = formulaire.elements[i].value;

            // Compose la chaîne data avec les champs contraintes dont la valeur
            // est définit et à 'Oui', ainsi que les champs qui ne sont pas des
            // contraintes
            if (typeof(value) != 'undefined' 
                && ((name.match(/contrainte_.*/) !== null && value == 'Oui') 
                    || name.match(/contrainte_.*/) === null)) {
                //
                data += name+"="+encodeURIComponent(value)+"&";
            }
        }
    }

    // execution de la requete en POST
    $.ajax({
        type: "POST",
        url: link,
        cache: false,
        data: data,
        dataType: "json",
        success: function(html){
            // Efface le message
            $('.message').remove();
            // Affiche le message
            $('.subtitle').after(
                '<div ' +
                    'class="message ui-widget ui-corner-all ui-state-highlight ui-state-valid">' +
                    '<p>' +
                        '<span class="ui-icon ui-icon-info"></span>' +
                        '<span class="text">' +
                            html +
                        '</span>' +
                    '</p>' +
                '</div>'                    
            );
            // Décoche toutes les checkbox
            $(":checkbox").attr('checked', false);
            $(":checkbox").attr('value', '');
        }
    });
}


/**
 * Permet de récupérer les avis des opérateurs kpark en mode modifier.
 */
function get_avis_from_operateur_kpark(tab_collterr) {
    // composition de la chaine data en fonction des elements du formulaire
    var data = [];
    for (j=0; j<tab_collterr; j++) {
        if ($("#tab_avis_"+j).attr('value') != 'no_select') {
            data[j] = $("#tab_avis_"+j).attr('value');
        } else {
            data[j] = 'no_select';
        }
    }

    $("#tab_avis_maj").get(0).value = JSON.stringify(data);
}

/**
 * Permet de recharger la page.
 */
function refresh_page_return() {
    // Recharge la page
    location.reload();
}

/**
 * Action permettant la génération d'une archive zip contenant les documents
 * numérisés de la page.
 *
 * @param {array}  var_text Chaînes d'affichage.
 * @param {string} dossier  Identifiant du DA ou DI (selon contexte pièce).
 */
function zip_doc_numerise(var_text, dossier, obj, action) {
    // Message d'attente
    waiting_message_loading ='<img src="../lib/om-assets/img/loading.gif" alt="'+var_text.waiting_message+'" />'+var_text.waiting_message;
    // Création du modal dialog de confirmation
    id_sousform = "#sousform-" + obj;
    addDivDialog(id_sousform);
    $( "#dialog" ).html(var_text.confirm_message);
    $( "#dialog" ).dialog({
        title: var_text.title,
        resizable: false,
        height:140,
        modal: true,
        buttons: [
            {
                text: var_text.confirm_button_ok,
                class : "ui-dialog-button-confirm",
                click: function() {
                    // Si confirmation :
                    // on enlève les boutons
                    $( "#dialog" ).dialog( "option", "buttons", {});
                    // on change le contenu du modal
                    $( "#dialog" ).html(waiting_message_loading);
                    // on récupère les identifiant des documents numérisés
                    ids = new Array();
                    $('tr td .lienDocumentNumerise').each(function() {
                        ids.push(this.id.replace("document_numerise_", ""));
                    });
                    // On appel le script de génération de l'archive
                    $.ajax({
                        url: "../app/index.php?module=form&obj=" + obj + "&action=" + action + "&idx=0&dossier="+dossier+"&ids="+ids.join(','),
                        dataType: "json"
                    }).done(
                        function(data) {
                            // Une fois la génération terminée on affiche l'erreur
                            // ou le lien de téléchargement
                            if(data.status == false) {
                                $( "#dialog" ).html(var_text.error_message);
                            } else {
                                link = '<a id="archive_download_link" href="../app/index.php?module=form&snippet=file&uid='+data.file+
                                    '&dl=download&mode=temporary">'+
                                    '<span class="om-icon om-icon-16 om-icon-fix archive-16" title="'+var_text.download_link_message+'">'+
                                    var_text.download_link_message+'</span>'+var_text.download_link_message+'</a>';
                                $( "#dialog" ).html(var_text.download_message+'<br/>'+link);
                            }
                        }
                    ).fail(
                        function() {
                            $( "#dialog" ).html(var_text.error_message);
                        }
                    );
                }
            }, {
                text: var_text.confirm_button_ko,
                class : "ui-dialog-button-cancel",
                click: function() {
                    $(this).dialog('close');
                }
            }
        ],
        //OnClose suppression du contenu
        close: function(ev, ui) {
            $(this).remove();
        }
    });
}

/**
 * Fonctions de cochage des items de dossier final
 */
function dossier_final_checkbox_select_all_none(checkbox) {
    if (checkbox.checked === true) {
        dossier_final_select_all();
    } else {
        dossier_final_select_none();
    }
}
function dossier_final_select_all(){
    $('.checkbox-dossier_final').each(function() {
          this.checked = true;
      });
}
function dossier_final_select_none(){
    $('.checkbox-dossier_final').each(function() {
          this.checked = false;
      });
}
function dossier_final_select_recommandees(){
    $('.checkbox-dossier_final').each(function() {
        if($(this).parents("tr").hasClass("dossier_final_piece_recommandee")){
            this.checked = true;
        }else
        {this.checked = false;}
    });
}

/**
 * Fonctions de cochage des items de l'onglet téléchargement
 */
function telechargement_checkbox_select_all_none(checkbox) {
    if (checkbox.checked === true) {
        telechargement_select_all();
    } else {
        telechargement_select_none();
    }
}
function telechargement_select_none(){
    $('.checkbox-telechargement').each(function() {
          this.checked = false;
      });
}
function telechargement_select_all(){
    $('.checkbox-telechargement').each(function() {
          this.checked = true;
      });
}

/**
 * Vérifie que des éléments sont cochés et retourne l'état coché/non coché des fichiers
 */
function get_fichiers_checked(context){

    $('#form-message-'+context).html(msg_loading);
    context = context.replace('-', '_');
    // Récupération des données
    var dataJson = "{\""+context+"\":[";
    $('.checkbox-'+context).each(
        function(){
            var id_table = $(this).attr("name")
            var idInput = $(this).attr("id");
            var champ_uid = $(this).attr("champ_uid");
            var checked = this.checked;
            dataJson += "{\"uid\":\"" + idInput + "\",\"champ_uid\":\""+ champ_uid + "\",\"table\":\""+ id_table +"\",\"val\":\""+ checked +"\"},";
        }
    );
    dataJson = $.parseJSON(dataJson.substring(0,dataJson.length-1)+"]}");
    // Retour des champs avec leur valeur
    return dataJson;
}

function constituer_dossier_final(dossier, obj){

     dataJson = get_fichiers_checked('dossier-final');
     if (dataJson == "") {
        return;
     }
    // On appel le script de constitution du dossier final
    $.ajax({
        type: "POST",
        url: "../app/index.php?module=form&obj=" + obj + "&action=301&idx=0&dossier="+dossier,
        dataType: "json",
        data: dataJson
    }).done(
        function(html) {
            $('#form-message-dossier-final').html(
                '<div class="message ui-widget ui-corner-all ui-state-highlight">'+
                    '<p>'+
                        '<span class="ui-icon ui-icon-info"></span>'+
                        '<span class="text">'+
                        'Le dossier final a bien été constitué.'+
                        '</span>'+
                    '</p>'+
                '</div>'
            );
            $('#telecharger-dossier-final').html(html.button_content);
            // Si le retour de l'appel Ajax n'est pas vide, alors il y a eu une
            // erreur lors du traitement
            if ( html.msg_error.length > 2 ) {
                $("#form-message-dossier-final .message").addClass("ui-state-error");
                $("#form-message-dossier-final .text").html(html.msg_error);
            } 
        }
    ).fail(
        function(html) {
            if(html.responseText.length > 0){
                $("#form-message-dossier-final .text").html(html.responseText);
            }
            else {
              $('#form-message-dossier-final').html(
                    '<div class="message ui-widget ui-corner-all ui-state-highlight">'+
                        '<p>'+
                            '<span class="ui-icon ui-icon-info"></span>'+
                            '<span class="text">'+
                            '</span>'+
                        '</p>'+
                    '</div>'
                );
                $("#form-message-dossier-final .message").addClass("ui-state-error");
                $("#form-message-dossier-final .text").html("Erreur lors de la constitution du dossier final.");
            }
        }
    );
}

/**
 * Fonctions de cochage des contraintes à supprimer
 */
 function dossier_contrainte_checkbox_select_all_none(checkbox) {
    if (checkbox.checked === true) {
        dossier_contrainte_select_all();
        // Si la case qui sélectionne toutes les contraintes est 
        // coché on décoche toutes les cases de sélection de constrainte par groupe
        $('.checkbox_select_all_groupe_none').each(function() {
            this.checked = true; 
        });
    } else {
        dossier_contrainte_select_none();
        // Si la case qui sélectionne toutes les contraintes est 
        // décoché on décoche toutes les cases de sélection de constrainte par groupe
        $('.checkbox_select_all_groupe_none').each(function() {
            this.checked = false; 
        });
    }
}
function dossier_contrainte_select_all(){
    $('.checkbox-contrainte_conserve').each(function() {
          this.checked = true;
      });
}
function dossier_contrainte_select_none(){
    $('.checkbox-contrainte_conserve').each(function() {
          this.checked = false;
      });
}

/**
 * Fonctions de cochage par groupe des contraintes à conserver
 */
function dossier_contrainte_checkbox_select_groupe(checkbox){
    id_parent = checkbox.id.replace('checkbox_select_all_groupe_', '');
    if (checkbox.checked === true) {
        $('#'+id_parent+' .checkbox-contrainte_conserve').each(function() {
            this.checked = true;
        });
    } else {
        $('#'+id_parent+' .checkbox-contrainte_conserve').each(function() {
            this.checked = false;
        });
        // On décoche la case de sélection de toutes les contraintes 
        // car un des groupes est déselectionné
        $('.checkbox_select_all_none').each(function() {
            this.checked = false; 
        });
    }
}

/**
 * Vérifie que des éléments sont cochés et retourne l'état coché/non coché des contraintes
 * et renvoie ces informations dans un json.
 * 
 * @return {json}
 */
 function getContrainteAConserver(){

    $('#form-message-contrainte-conserve').html(msg_loading);

    // Récupération des données
    var dataJson = "{\"contraintes_a_conserver\":[";
    $('.checkbox-contrainte_conserve').each(
        function(){
            var idInput = $(this).attr("id");
            var checked = this.checked;
            dataJson += "{\"id\":\"" + idInput + "\",\"val\":\"" + checked + "\"},";
        }
    );
    dataJson = $.parseJSON(dataJson.substring(0,dataJson.length-1)+"]}");
    // Retour des champs avec leur valeur
    return dataJson;
}

/**
 * Fait appel à l'action permettant de supprimer les contraintes non séléctionnées.
 * Actualise la page et affiche un message indiquant si le traitement à réussi.
 * 
 * @param {string} dossier 
 * @param {string} obj 
 * @returns 
 */
function supprimer_contraintes_non_selectionnees(dossier, obj){
    dataJson = getContrainteAConserver();
    if (dataJson == "") {
       return;
    }
    // On appel le script de suppression des contraintes
    $.ajax({
        type: "POST",
        url: "../app/index.php?module=form&obj=" + obj + "&action=6&idx=0&dossier=" + dossier,
        dataType: "json",
        data: dataJson
    }).done(
        function(html) {
            form_container_refresh("sousform");
            $('#sousform-dossier_contrainte #sousform-message').html(
                '<div class="message ui-widget ui-corner-all ui-state-highlight">'+
                    '<p>'+
                        '<span class="ui-icon ui-icon-info"></span>'+
                        '<span class="text">'+
                        '</span>'+
                    '</p>'+
                '</div>'
            );
            $('#sousform-dossier_contrainte #sousform-message span.text').html(html.msg_validation);
            // Si le retour de l'appel Ajax n'est pas vide, alors il y a eu une
            // erreur lors du traitement
            if ( html.msg_error.length > 2 ) {
                $("#sousform-dossier_contrainte #sousform-message .message").addClass("ui-state-error");
                $("#sousform-dossier_contrainte #sousform-message .text").html(html.msg_error);
            } 
        }
    ).fail(
        function(html) {
            form_container_refresh("sousform");
            if(html.responseText.length > 0){
                $("#sousform-dossier_contrainte #sousform-message .text").html(html.responseText);
            }
            else {
                $('#sousform-dossier_contrainte #sousform-message').html(
                    '<div class="message ui-widget ui-corner-all ui-state-highlight">'+
                        '<p>'+
                            '<span class="ui-icon ui-icon-info"></span>'+
                            '<span class="text">'+
                            '</span>'+
                        '</p>'+
                    '</div>'
                );
                $("#sousform-dossier_contrainte #sousform-message .message").addClass("ui-state-error");
                $("#sousform-dossier_contrainte #sousform-message .text").html("Erreur lors de la suppression des contraintes.");
            }
        }
    );
}

/**
 * Action permettant la génération d'une archive zip contenant 
 * les documents du dernier dossier final constitué
 *
 * @param {array}  var_text Chaînes d'affichage.
 * @param {array}  uids   Les uid des fichiers du dossier final.
 * @param {string} dossier  Identifiant du DI.
 * @param {string} obj    Nom de l'obj
 */
function generate_archive_dossier_final(var_text, uids, dossier, obj) {
    // Message d'attente
    waiting_message_loading ='<img src="../lib/om-assets/img/loading.gif" alt="'+var_text.waiting_message+'" />'+var_text.waiting_message;
    // Création du modal dialog de confirmation
    id_sousform = "#sousform-" + obj;
    addDivDialog(id_sousform);
    $( "#dialog" ).html(var_text.confirm_message);
    $( "#dialog" ).dialog({
        title: var_text.title,
        resizable: false,
        modal: true,
        buttons: [
            {
                text: var_text.confirm_button_ok,
                class : "ui-dialog-button-confirm",
                click: function() {
                    // Si confirmation :
                    // on enlève les boutons
                    $( "#dialog" ).dialog( "option", "buttons", {});
                    // on change le contenu du modal
                    $( "#dialog" ).html(waiting_message_loading);
                    // On appel le script de génération de l'archive
                    $.ajax({
                        url: "../app/index.php?module=form&obj=" + obj + "&action=302&idx=0&dossier="+dossier+"&ids="+uids.join(','),
                        dataType: "json",
                    }).done(
                        function(data) {
                            // Une fois la génération terminée on affiche l'erreur
                            // ou le lien de téléchargement
                            if(data.status == false) {
                                $( "#dialog" ).html(var_text.error_message);
                                 $( "#dialog" ).html("Nein");
                            } else {
                                link = '<a id="archive_download_link" href="../app/index.php?module=form&snippet=file&uid='+data.file+
                                    '&dl=download&mode=temporary">'+
                                    '<span class="om-icon om-icon-16 om-icon-fix archive-16" title="'+var_text.download_link_message+'">'+
                                    var_text.download_link_message+'</span>'+var_text.download_link_message+'</a>';
                                    $( "#dialog" ).html(var_text.download_message+'<br/>'+link);
                            }
                        }
                    ).fail(
                        function(data) {
                            $( "#dialog" ).html(var_text.error_message);
                        }
                    );
                }
            }, {
                text: var_text.confirm_button_ko,
                class : "ui-dialog-button-cancel",
                click: function() {
                    $(this).dialog('close');
                }
            }
        ],
        //OnClose suppression du contenu
        close: function(ev, ui) {
            $(this).remove();
        }
    });
}

/**
 * Action permettant la génération d'une archive zip contenant 
 * les documents sélectionnés dans l'onglet téléchargement et 
 * l'affichage d'un popup permettant de le télécharger
 *
 * @param {array}  var_text Chaînes d'affichage.
 * @param {string} dossier  Identifiant du DI.
 * @param {string} obj    Nom de l'obj
 */
function archive_telechargement(var_text, dossier, obj) {
    // récupération des fichiers sélectionnés
    dataJson = get_fichiers_checked('telechargement');
    if (dataJson == "") {
        return;
    }
    uids = [];
    dataJson.telechargement.forEach(function (element) { if (element.val == "true") {uids.push(element.uid);}})

    if (uids.length == 0) {
        // Le click sur le bouton affiche un message, on le supprime
        $('#form-message-telechargement').html("");
        return;
    }
    // Message d'attente
    waiting_message_loading ='<img src="../lib/om-assets/img/loading.gif" alt="'+var_text.waiting_message+'" />'+var_text.waiting_message;
    // Création du modal dialog de confirmation
    id_sousform = "#sousform-" + obj;
    addDivDialog(id_sousform);
    $( "#dialog" ).html(var_text.confirm_message);
    $( "#dialog" ).dialog({
        title: var_text.title,
        resizable: false,
        modal: true,
        buttons: [
            {
                text: var_text.confirm_button_ok,
                class : "ui-dialog-button-confirm",
                click: function() {
                    // Si confirmation :
                    // on enlève les boutons
                    $( "#dialog" ).dialog( "option", "buttons", {});
                    // on change le contenu du modal
                    $( "#dialog" ).html(waiting_message_loading);
                    // On appel le script de génération de l'archive
                    $.ajax({
                        url: "../app/index.php?module=form&obj=" + obj + "&action=304&idx=0&dossier="+dossier+"&ids="+uids.join(','),
                        dataType: "json",
                    }).done(
                        function(data) {
                            // Une fois la génération terminée on affiche l'erreur
                            // ou le lien de téléchargement
                            if(data.status == false) {
                                $( "#dialog" ).html(var_text.error_message);
                                 $( "#dialog" ).html("Nein");
                            } else {
                                link = '<a id="archive_download_link" href="../app/index.php?module=form&snippet=file&uid='+data.file+
                                    '&dl=download&mode=temporary">'+
                                    '<span class="om-icon om-icon-16 om-icon-fix archive-16" title="'+var_text.download_link_message+'">'+
                                    var_text.download_link_message+'</span>'+var_text.download_link_message+'</a>';
                                    $( "#dialog" ).html(var_text.download_message+'<br/>'+link);
                            }
                        }
                    ).fail(
                        function(data) {
                            $( "#dialog" ).html(var_text.error_message);
                        }
                    );
                }
            }, {
                text: var_text.confirm_button_ko,
                class : "ui-dialog-button-cancel",
                click: function() {
                    $(this).dialog('close');
                    // On supprime le message de traitement en cours
                    $('#form-message-telechargement').html("");
                }
            }
        ],
        //OnClose suppression du contenu
        close: function(ev, ui) {
            $(this).remove();
            // On supprime le message de traitement en cours
            $('#form-message-telechargement').html("");
        }
    });
}

function manage_display_demande(idx_datd) {
    var request = $.ajax({
        type: "GET",
        url: "../app/index.php?module=form&obj=dossier_autorisation_type_detaille&action=4&idx="+idx_datd,
        cache: false,
        // La requête doit être synchrone car c'était l'une des deux causes d'un
        // bug qui cassait les champs custom de références cadastrales et
        // certains de leurs boutons. Pour une raison qui n'a pas été comprise
        // (c'est la folie tout ce qui se passe pour formater (3 fois!) ces
        // champs customs) cela provoque un appel récursif de
        // formatFieldReferenceCadastrale(). Et le fait d'avoir 2 appels
        // imbriqués fait que l'état est incohérent. Donc la création des champs
        // et des boutons ne se fait pas bien.
        //
        // Il est possible de rendre à nouveau cette requête asynchrone en
        // allant voir où manage_display_demande() est appelée. Puis de mettre
        // la suite du code (ce qui se passe après l'appel à
        // manage_display_demande()) dans le callback pour que l'ordre
        // d'exécution soit le même que avec la requête synchrone. Le but est
        // d'éviter de freezer toute la page web pendant la requète au serveur
        // (temps réseau + traitement serveur)
        //
        // manage_display_demande() est appelée à deux endroits donc c'est peut
        // être eux qui vont devoir fournir le callback.
        async: false,
        dataType: "json"
    });
    request.done(function(affichage_form) {
        $('.demande_autorisation_contestee_hidden_bloc').hide();
        hideFields();
        
        switch(affichage_form) {
            
            case 'CTX RE':
                // On affiche le champ de recherche de dossier à contester
                $('.demande_autorisation_contestee_hidden_bloc').show();
                // Désactivation de la validation du formulaire de la demande
                // par l'appui sur la touche entrée
                $(document).on("keypress", '#autorisation_contestee', function (e) {
                    var code = e.keyCode || e.which;
                    if (code == 13) {
                        e.preventDefault();
                        return false;
                    }
                });
                // Dans le cas d'un formulaire soumis en erreur le champ
                // peut être déjà saisie, on recherche donc les informations
                if ($('#autorisation_contestee').val() != '') {
                    lookingForAutorisationContestee();
                }
                break;
            default:
                showFormDemande();
                break;
        }
    });
}

/**
 * Méthode de mise en forme semblable à sprintf :
 * "lorem {0} dolor {1} amet".format("ipsum", "sit");
 *
 * @return,  string Chaîne fourni avec remplacement des index
 */
String.prototype.format = function () {
        var args = [].slice.call(arguments);
        return this.replace(/(\{\d+\})/g, function (a){
            return args[+(a.substr(1,a.length-2))||0];
        });
};


/**
 * Enregistre le contenu d'un rendu PDF au format base64
 * dans une variable 'globale' dont la portée est gérée
 * par jQuery
 */
function set_jquery_data_var_pdf(base64_content) {
    window.pdfjs_content_b64 = atob(base64_content);
}

/**
 * Affiche l'iframe de prévisualisation PDF
 * (écrasée à chaque rechargement)
 */
function load_iframe_pdf() {
    // Détection du navigateur et de sa version
    // https://stackoverflow.com/questions/5916900
    navigator.sayswho= (function(){
        var ua= navigator.userAgent, tem, 
        M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
        if(/trident/i.test(M[1])){
            tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
            return 'IE '+(tem[1] || '');
        }
        if(M[1]=== 'Chrome'){
            tem= ua.match(/\b(OPR|Edge)\/(\d+)/);
            if(tem!= null) return tem.slice(1).join(' ').replace('OPR', 'Opera');
        }
        M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
        if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
        return M;
    })();

    // Charge la librairie pdfjs récente ou pdfjs ancienne en fonction du navigateur et de sa version
    if ((navigator.sayswho[0].toLowerCase() === 'firefox' && parseInt(navigator.sayswho[1], 10) < 74)
        || (navigator.sayswho[0].toLowerCase() === 'chrome' && parseInt(navigator.sayswho[1], 10) < 80)) {
        //
        $("#frame_content").html('<iframe src="lib/pdfjs-2.0.943/web/om_viewer.html" id="frame_pdf"></iframe>');
    } else {
        $("#frame_content").html('<iframe src="lib/pdfjs-2.10.377/web/om_viewer.html" id="frame_pdf"></iframe>');
    }
}

/**
 * Recharge le contenu du PDF de prévisualisation
 *
 * @return void
 */
function reload_pdf_viewer() {
    var link = "../app/index.php?module=form&obj=instruction&action=777&idx="+$(".form-content #instruction").val();
    var params ='';
    if (tinyMCE.get('corps_om_htmletatex') != null) {
        params += '&corps='+encodeURIComponent(tinyMCE.get('corps_om_htmletatex').getContent());
    }
    if (tinyMCE.get('titre_om_htmletat') != null) {
        params += '&titre='+encodeURIComponent(tinyMCE.get('titre_om_htmletat').getContent());
    }
    if (tinyMCE.get('complement_om_html') != null) {
        params += '&c1='+encodeURIComponent(tinyMCE.get('complement_om_html').getContent());
    }
    if (tinyMCE.get('complement2_om_html') != null) {
        params += '&c2='+encodeURIComponent(tinyMCE.get('complement2_om_html').getContent());
    }
    if (tinyMCE.get('complement3_om_html') != null) {
        params += '&c3='+encodeURIComponent(tinyMCE.get('complement3_om_html').getContent());
    }
    if (tinyMCE.get('complement4_om_html') != null) {
        params += '&c4='+encodeURIComponent(tinyMCE.get('complement4_om_html').getContent());
    }
    $.ajax({
        type: "POST",
        url: link,
        data: params,
        dataType: "json",
        async: false,
        success: function(data){
            // Enregistre le contenu du fichier PDF dans une variable globale
            // qui sera ensuite utilisée dans l'iframe pour charger le document
            set_jquery_data_var_pdf(data.base);
            // Affiche l'iframe (écrase à chaque rechargement)
            load_iframe_pdf();
            // Redimensionne la taille de l'iframe contenant le PDF
            resize_frame_pdf();
            // Positionne l'écran au début de la prévisualisation
            $(window).scrollTop($(".container_instr_edition").offset().top);
        }
    });
}


/**
 * Redimensionne l'iframe contenant le PDF de prévisualisation lors de la
 * modification d'une instruction.
 *
 * @return void
 */
function resize_frame_pdf() {
    //
    if (screen.width <= 1280 || $(window).width() <= 1266) {
        $("#frame_pdf").height($('.box_instr_edition').height());
    } else {
        // Récupère la taille du container comprenant les éléments de rédaction
        var height = $('.box_instr_edition').height();
        // Redimensionne l'iframe en supprimant les élements au dessus
        // et en dessous de l'iframe
        $("#frame_pdf").height(height-87);
    }
}


/**
 * Initialise la vue du type de champ jsontotab 
 * en utilisant la librairie gridjs
 *
 * @return void
 */
function init_view_jsontotab(champ, columns_tab, data_tab) {
    new gridjs.Grid({ 
        columns: columns_tab,
        data: data_tab,
        width: 'none',
        style: {
            container: {
                'font-weight' : 'normal'
            },
            td: {
              'padding-top': '5px',
              'padding-bottom': '5px',
              'padding-left': '7px',
              'padding-right': '7px',
              color: '#4d4d4d',
              'font-size': '90%'
            },
            th: {
              'padding-top': '5px',
              'padding-bottom': '5px',
              'padding-left': '7px',
              'padding-right': '7px',
              'font-variant': 'small-caps'
            }
        }
    }).render(document.getElementById(champ+'_jsontotab'));
}


/**
 * Permet d'afficher tout les dossiers consultés. (limit à 20)
 *
 * @param {string} widget_id Identifiant du widget
 *
 * @return void
 */
function get_all_dossier_consulte(widget_id) {
    $("div #" + widget_id + " tr").show(); 
    $("div #" + widget_id + " .widget-footer").hide();
}

/**
 * Hack rapide pour modifier les messages de confirmations lors des clics
 * sur les boutons du Portlet 'Rédaction libre' et 'Rédaction par compléments'
 **/
function modify_confirm_msg_for_portlet_btn_redaction()
{
    actions = ['enable', 'disable'];
    for(i = 0; i < actions.length; i++) {
        btn_id = 'action-sousform-instruction-' + actions[i] + '-edition-integrale';
        $('#' + btn_id).off('click').on('click', function(event) {
            //
            if ($(this).attr('class').indexOf("action-with-confirmation") >= 0) {
                redaction_form_confirmation_action(form_execute_action_direct, "sousform", this);
            } else {
                form_execute_action_direct("sousform", this);
            }
            //
            return false;
        });
    }
}

/**
 * Copie modifiée de la fonction form_confirmation_action() afin de ne pas
 * modifier les fonctions du 'core' (framework openMairie).
 * Hack rapide en lien avec la fonction
 * modify_confirm_msg_for_portlet_btn_redaction() ci-dessus
 * afin de modifier le message de confirmation de certains boutons
 **/
function redaction_form_confirmation_action(callback, elem, btn) {
    var redaction_libre_action = $(btn).attr('id')
                                       .replace('action-sousform-instruction-', '')
                                       .replace('-edition-integrale', '');
    var msg_confirm = redaction_libre_action == 'enable'
                    ? 'Êtes-vous sûr de vouloir activer le mode "Rédaction Libre" ?<br/><br/><span>Le contenu de vos compléments va être intégré dans le document, dont vous pourrez modifier librement l\'intégralité.</span>'
                    : 'Êtes-vous sûr de vouloir activer le mode "Rédaction par Compléments" ?<br/><br/><span style="font-weight: bold; color: red;">Attention: toute la rédaction manuelle réalisée sera perdue.</span>';

    $('#dialog-action-confirmation').remove();
    
    //-- à partir d'ici, c'est une copie strict de la form_confirmation_action()
    
    var dialogbloc = $("<div id=\"dialog-action-confirmation\">"+msg_confirm+"</div>").insertAfter('#footer');
    //
    $(dialogbloc).dialog( "destroy" );
    $(dialogbloc).dialog({
        resizable: false,
        height:200,
        width:350,
        modal: true,
        buttons: [
            {
                text: msg_form_action_confirmation_button_confirm,
                class: "ui-dialog-button-confirm",
                    click: function() {
                        $(this).dialog("close");
                        callback(elem, btn);
                    }
            }, {
                text: msg_form_action_confirmation_button_cancel,
                class : "ui-dialog-button-cancel",
                    click: function() {
                        $(this).dialog("close");
                    }
            }
        ]
    });
}

/**
 * Copie modifiée des fonctions form_confirmation_action() et
 * form_execute_action_direct() afin de ne pas modifier les fonctions du 'core'
 * (framework openMairie).
 *
 * Fenêtre modale de confirmation spécifique à l'action d'export d'un fichier
 * SITADEL.
 */
function sitadel_form_confirmation_action(elem, action, msg) {
    //
    $('#dialog-action-confirmation').remove();
    var dialogbloc = $("<div id=\"dialog-action-confirmation\">"+msg+"</div>").insertAfter('#footer');
    //
    $(dialogbloc).dialog( "destroy" );
    $(dialogbloc).dialog({
        resizable: false,
        height:200,
        width:350,
        modal: true,
        buttons: [
            {
                text: msg_form_action_confirmation_button_confirm,
                class: "ui-dialog-button-confirm",
                    click: function() {
                        $(this).dialog("close");
                        //
                        $('#'+elem+'-message').html(msg_loading);
                        //
                        $.ajax({
                            type: "POST",
                            url: $(action).attr('data-href')+"&validation=1&contentonly=true",
                            cache: false,
                            dataType: "html",
                            data: "datedebut="+action.form.datedebut.value+"&datefin="+action.form.datefin.value+"&numero="+action.form.numero.value,
                            success: function(html){
                                // XXX Il semble nécessaire afin de récupérer la portion de code
                                // div.message d'ajouter un container qui contient l'intégralité
                                // du code html représentant le contenu du formulaire. Si on ajoute
                                // pas ce bloc la récupération du bloc ne se fait pas.
                                container_specific_js = '<div id="container-specific-js">'+html+'</div>';
                                message = $(container_specific_js).find('div.message').get(0);
                                if (message == undefined) {
                                    message = -1;
                                }
                                // Ajout du contenu récupéré (uniquement le bloc message)
                                $('#'+elem+'-message').html(message);
                                // Rafraichissement du bloc de formulaire
                                form_container_refresh(elem);
                                // Initialisation JS du nouveau contenu de la page
                                om_initialize_content();
                            }
                        });
                    }
            }, {
                text: msg_form_action_confirmation_button_cancel,
                class: "ui-dialog-button-cancel",
                    click: function() {
                        $(this).dialog("close");
                    }
            }
        ]
    });
}

/**
 * Défini l'url pour charger le contenu de l'onglet DI.
 * (uniquement dans le cas d'un clic depuis un autre onglet
 * et si l'url n'est pas déjà défini).
 * Cela permet de forcer le (re)chargement du contenu de l'onglet DI
 * à chaque clic sur l'onglet DI.
 *
 * @return  boolean  'true' si clique sur un DI à partir d'un autre onglet, sinon 'false'
 */
function set_di_href_in_data_load_tabs(evt, ui) {
    var ret = false;

    // Réinitialisation de la valeur de la barre de recherche lors
    // du passage d'un sous-formulaire à un autre
    $('#recherchedyn').val("");

    // recherche l'index de l'onglet 'DI' et son noeud DOM
    var di_tab_title_node = null;
    var di_tab_index = -1;
    var di_tab_node = null;
    var list_of_tabs = $('.ui-tabs-nav li');
    for (var i = 0; i < list_of_tabs.length; i++) {
        var tab = list_of_tabs.get(i);
        var tab_title_node = $(tab).find('> a');
        if(tab_title_node && tab_title_node.length == 1) {
            tab_title_node.contents().filter(function() {
                return this.nodeType == Node.TEXT_NODE;
            });
            var tab_title = null;
            if (tab_title_node) {
                tab_title = $(tab_title_node).text().trim();
            }
            if (tab_title == 'DI') {
                di_tab_title_node = tab_title_node.get(0);
                di_tab_index = i;
                break;
            }
        }
    }

    // si l'onglet DI existe (son index a été trouvé)
    if (di_tab_index != -1 && di_tab_title_node) {
        // récupère l'id de l'onglet actuellement sélectionné
        var tabIdSelectedFrom = $("#formulaire").tabs('option', 'selected');
        // si on clic sur l'onglet DI à partir d'un autre onglet
        if (ui.tab == di_tab_title_node && tabIdSelectedFrom != di_tab_index) {
            ret = true;
            // récupère la source (href) de l'onglet DI actuellement définie
            var tab_href = $.data(di_tab_title_node, 'load.tabs');
            // si l'onglet n'a aucune source distante définie
            if (!tab_href) {
                // récupère l'URL de la page courante
                // (sans le hash car celui-ci est utilisé pour afficher un autre onglet)
                var tab_href = window.location.href;
                if (tab_href.indexOf('#') != -1) {
                    tab_href = window.location.href.split('#')[0];
                }
            }
            // une recherche dynamique est disponible
            var recherchedyn = document.getElementById("recherchedyn");
            if (recherchedyn) {
                // retire l'id de la recherche dynamique (car ajouté systématiquement après)
                tab_href = tab_href.replace(/&advs_id=[^&#]*/ig, '');
                // met à jour l'id de la recherche dynamique (car utilisé par la fonction suivante)
                // si cet id n'est pas mis à jour, le bouton retour de l'onglet DI nouvellement
                // généré aura l'id de recherche d'une recherche vide (si aucune recherche n'a été
                // effectuée)
                var search_params = new URLSearchParams(window.location.search);
                if (search_params) {
                    var advs_id = search_params.get('advs_id');
                    if (advs_id) {
                        var current_advs_id = $('#advs_id').get(0).value;
                        if (current_advs_id != advs_id) {
                            $('#advs_id').get(0).value = advs_id;
                        }
                    }
                }
            }
            // défini la source (href) de l'onglet DI (ce qui provoquera son rechargement)
            $.data(di_tab_title_node, 'load.tabs', tab_href);
        }
    }
    return ret;
}


/**
 * Fonctions pour la mise à jour des champs composant le numéro de dossier
 * d'une nouvelle demande.
 */

/**
 * Affiche/cache les champs composant la numérotation manuelle
 *
 * @return void
 */
function toggle_num_dossier_manuel(saisie_manuelle_node, onload) {

    // met à jour le type de dossier d'autorisation
    update_num_dossier_type_da($('select#dossier_autorisation_type_detaille')[0]);

    // si la case de la saisie manuelle du numéro de dossier vient d'être cochée
    if (saisie_manuelle_node.checked === true) {

        // Affiche le bloc pour la numérotation manuelle
        if (typeof(onload) === 'undefined' || onload === false) {

            // détermine le noeud DOM approprié pour le calcul du champ du
            // code département-commune
            var node_for_code_depcom = $('#om_collectivite')[0];
            var commune_node = document.getElementById('commune');
            if (! commune_node) {
                commune_node = document.getElementById('autocomplete-commune-id');
            }
            if (commune_node) {
                node_for_code_depcom = commune_node;
            }

            // met à jour les différents champs qui compose le numéro de dossier
            update_num_dossier_code_depcom(node_for_code_depcom);
            update_num_dossier_annee($('input#date_demande'));
            update_num_dossier_division();
            update_num_dossier_seq(true);

            // montre le bloc de numéro manuelle de dossier
            $("div.bloc_num_manu").show('fast', 'swing');
        }

        // cache le bloc de numéro manuelle de dossier
        else {
            $("div.bloc_num_manu").show();
        }
    }

    // case de la saisie manuelle du numéro de dossier vient d'être décochée
    else {

        // Cache le bloc de la numérotation manuelle
        if (typeof(onload) === 'undefined' || onload === false) {
            $("div.bloc_num_manu").hide('fast', 'swing');
        } else {
            $("div.bloc_num_manu").hide();
        }
    }
}

/**
 * Affiche/cache les champs composant la numérotation manuelle
 *
 * @return void
 */
function toggle_num_dossier_manuel_complet(saisie_manuelle_node, onload) {

    //
    if (saisie_manuelle_node.checked === true) {
        // Affiche le bloc pour la numérotation manuelle
        if (typeof(onload) === 'undefined' || onload === false) {
            $("div.bloc_num_manu").show('fast', 'swing');
        } else {
            $("div.bloc_num_manu").show();
        }
    }
    else {
        // Cache le bloc de la numérotation manuelle
        if (typeof(onload) === 'undefined' || onload === false) {
            $("div.bloc_num_manu").hide('fast', 'swing');
        } else {
            $("div.bloc_num_manu").hide();
        }
    }
}

/**
 * [verifier_numerotation_urbanisme description]
 * @param  {[type]} num_complet [description]
 * @return {[type]}             [description]
 */
function verifier_numerotation_urbanisme(num_complet) {

    // vider le message d'erreur
    $('#complet_err_msg').remove();

    // si la valeur est vide: rien à faire
    if (num_doss_complet.value.trim() === "") {
        return;
    }

    //
    var datd_id = document.getElementById('dossier_autorisation_type_detaille');
    var demande_type_id = document.getElementById('demande_type');

    // Récupère l'objet de l'url courante
    var obj = getUrlParamValue('obj', window.location.search);
    if (!obj || (obj != 'demande_nouveau_dossier'
            && obj != 'demande_nouveau_dossier_contentieux')) {
        //
        obj = 'demande_nouveau_dossier';
    }

    //
    var url = '../app/index.php?module=form&obj='+obj+'&action=160'
        + '&num_doss_complet=' + encodeURIComponent(num_doss_complet.value)
        + '&datd_id=' + encodeURIComponent(datd_id.value)
        + '&demande_type_id=' + encodeURIComponent(demande_type_id.value);
    $.ajax({
        url: url,
        dataType: "json",
        success: function(data) {
            //
            if (data && typeof(data) == 'object' && 'info_msg' in data) {
                var err_msg_elt = document.getElementById('complet_err_msg');
                if (! err_msg_elt) {
                    $('div.complet').append(
                        '<div id="complet_err_msg">'+ data['info_msg'] +'</div>');
                }
                else {
                    $(err_msg_elt).html(data['info_msg']);
                }
            }
        }
    });
}

/**
 * Met à jour le code du type de dossier d'autorisation composant la
 * numérotation du dossier.
 *
 * @return void
 */
function update_num_dossier_type_da(type_da_node) {

    // si le champ du type DA du numéro de dossier existe
    var num_doss_type_da_node = document.getElementById('num_doss_type_da');
    if (num_doss_type_da_node) {

        // détermine le noeud DOM de référence pour le type de DAdt
        type_da_node = type_da_node || document.getElementById('dossier_autorisation_type_detaille');

        // si une valeur est renseignée pour le DAdt
        if (type_da_node.value) {

            // si la valeur est valide
            var type_da = type_da_node.value;
            var type_da_regex = new RegExp('^[0-9]{1,3}$');
            if (type_da_regex.test(type_da)) {

                // récupère l'objet de l'url courante
                var obj = getUrlParamValue('obj', window.location.search);
                if (! obj || (obj != 'demande_nouveau_dossier'
                        && obj != 'demande_nouveau_dossier_contentieux')) {
                    obj = 'demande_nouveau_dossier';
                }

                // récupère le code du DA et met à jour le champ
                var url = '../app/index.php?module=form&obj='+obj+'&action=140'
                        + '&type_dadt=' + encodeURIComponent(type_da);
                $.ajax({
                    url: url,
                    dataType: "json",
                    success: function(data) {
                        if (data && typeof(data) == 'object' && 'code_type_da' in data) {
                            num_doss_type_da_node.value = data['code_type_da'];
                            $(num_doss_type_da_node).trigger('change');
                        }
                    }
                });
            }

            // valeur invalide : on vide le champ
            else {
                num_doss_type_da_node.value = '';
                $(num_doss_type_da_node).trigger('change');
            }
        }

        // pas de valeur : on vide le champ
        else {
            num_doss_type_da_node.value = '';
            $(num_doss_type_da_node).trigger('change');
        }
    }
}

/**
 * Récupère l'année sur deux caractères depuis la date de la demande.
 *
 * @return string
 */
function get_date_demande_annee(date_demande_node) {
    if (date_demande_node.attr("id") == "date_depot_mairie" && date_demande_node[0].value == "") {
        date_demande_node = $('input#date_demande')
    }
    // si le champ date demande existe
    if (date_demande_node.exists() === true) {

        // si sa valeur est valide (date à la française)
        var date = date_demande_node[0].value;
        var date_regex = new RegExp('^[0-9]{2}/[0-9]{2}/([0-9]{4})$');
        if (date_regex.test(date)) {

            // on renvoie l'année
            return date.replace(date_regex, '$1').substring(2);
        }
    }

    // on renvoie une chaine vide par défaut
    return '';
}

/**
 * Met à jour l'année composant la numérotation du dossier.
 *
 * @return void
 */
function update_num_dossier_annee(date_demande_node) {

    // si le champ de l'année du numéro de dossier existe
    var num_doss_annee_node = document.getElementById('num_doss_annee');
    if (num_doss_annee_node) {

        // si le champ de la date_demande existe et permet de calculer l'année
        if ($('input#date_depot_mairie').attr("type") == "hidden" || ($('input#date_depot_mairie').attr("type") != "hidden" && $('input#date_depot_mairie').val() == "")) {
            var date_annee = get_date_demande_annee(date_demande_node);
        } else {
            var date_annee = get_date_demande_annee($('input#date_depot_mairie')); 
        }
        if (typeof(date_annee) !== 'undefined') {
            num_doss_annee_node.value = date_annee;
            $(num_doss_annee_node).trigger('change');
        }

        // si aucune année : on vide le champ
        else {
            num_doss_annee_node.value = '';
            $(num_doss_annee_node).trigger('change');
        }
    }
}

/**
 * Met à jour le code du département et le code de la commune composant la
 * numérotation du dossier.
 *
 * @return void
 */
var regex_positive_integer = new RegExp('^[0-9]+$');
function update_num_dossier_code_depcom(event_node) {

    // si le champ code département-commune existe
    // et que le noeud cible de l'évènement est l'un des noeuds attendus
    var num_doss_code_depcom_node = document.getElementById('num_doss_code_depcom');
    if (num_doss_code_depcom_node && event_node &&
            ['om_collectivite', 'commune', 'autocomplete-commune-id'].indexOf(event_node.id) != -1) {

        // récupère l'objet de l'url courante
        var obj = getUrlParamValue('obj', window.location.search);
        if (! obj || (obj != 'demande_nouveau_dossier'
                && obj != 'demande_nouveau_dossier_contentieux')) {
            obj = 'demande_nouveau_dossier';
        }

        var url = '../app/index.php?module=form&obj='+obj+'&action=141';
        var url_param_to_add = null;

        // le champ 'commune' existe donc on l'utilise (sous forme de select normal ou autocomplete)
        var commune_node = document.getElementById('commune');
        if (! commune_node) {
            commune_node = document.getElementById('autocomplete-commune-id');
        }
        if (commune_node) {

            // le champ 'commune' existe et le déclencheur est le champ 'om_collectivite'
            // on ne fait rien
            if (event_node.id == 'om_collectivite') {
                return;
            }

            // sinon on ajoute le paramètre de la commune à l'url
            var commune_id = commune_node.value
            if (regex_positive_integer.test(commune_id)) {
                url_param_to_add = '&commune_id=' + encodeURIComponent(commune_id);
            }
        }
        // le déclencheur est le champ 'collectivité' et le champ 'commune' n'existe pas
        else if (event_node.id == 'om_collectivite') {
            var collectivite_id = event_node.value;
            if (regex_positive_integer.test(collectivite_id)) {
                url_param_to_add = '&collectivite_id=' + encodeURIComponent(collectivite_id);
            }
        }

        // ajoute le paramètre à l'url et lance la requête Ajax
        if (url_param_to_add) {
            url += url_param_to_add;

            // récupération et mise à jour du code département-commune
            $.ajax({
                url: url,
                dataType: "json",
                success: function(data) {
                    if (data && typeof(data) == 'object' && 'code_depcom' in data) {
                        num_doss_code_depcom_node.value = data['code_depcom'];
                        $(num_doss_code_depcom_node).trigger('change');
                    }
                }
            });
        }

        // si on a aucun paramètre pour construire l'URL : on vide le champs
        else {
            num_doss_code_depcom_node.value = '';
            $(num_doss_code_depcom_node).trigger('change');
        }
    }
}

/**
 * Met à jour la division composant la numérotation du dossier.
 *
 * @return void
 */
function update_num_dossier_division() {

    // si le champ de la division du numéro de dossier existe
    var doss_division_node = document.getElementById('num_doss_division');
    if (doss_division_node) {

        // récupération des informations nécessaires pour le calcul de la division
        // de l'instructeur affecté automatiquement
        var om_collectivite_node = document.getElementById('om_collectivite');
        var datd_node = document.getElementById('dossier_autorisation_type_detaille');

        // si on les champs requis existent et leurs valeurs sont valides
        if (om_collectivite_node && datd_node && om_collectivite_node.value &&
                om_collectivite_node.value != '0' && datd_node.value && datd_node.value != '0') {

            // la vérification se fait seulement sur la première parcelle saisie
            var ref_cadas_quar = $('div.reference_cadastrale_custom_fields input.champFormulaire:nth-child(1)');
            var ref_cadas_sect = $('div.reference_cadastrale_custom_fields input.champFormulaire:nth-child(2)');
            var ref_cadas_parc = $('div.reference_cadastrale_custom_fields input.champFormulaire:nth-child(3)');
            var ref_cadas = '';
            if (ref_cadas_quar.exists() && ref_cadas_sect.exists() && ref_cadas_parc.exists()) {
                ref_cadas = ref_cadas_quar[0].value + ref_cadas_sect[0].value + ref_cadas_parc[0].value;
            }

            // récupère l'objet de l'url courante
            var obj = getUrlParamValue('obj', window.location.search);
            if (! obj || (obj != 'demande_nouveau_dossier'
                    && obj != 'demande_nouveau_dossier_contentieux')) {
                obj = 'demande_nouveau_dossier';
            }

            // composition de l"URL permettant de récupérer le code de la division
            var url = '../app/index.php?module=form&obj='+obj+'&action=143'
                + '&om_collectivite=' + encodeURIComponent(om_collectivite_node.value)
                + '&datd=' + encodeURIComponent(datd_node.value)
                + '&ref_cadas=' + encodeURIComponent(ref_cadas);

            // cas de la commune associé aux dossier
            var commune_node = document.getElementById('commune');
            if (! commune_node) {
                commune_node = document.getElementById('autocomplete-commune-id');
            }
            if (commune_node) {
                url += '&commune=' + encodeURIComponent(commune_node.value);
            }

            // récupération de la division et mise à jour du champ
            $.ajax({
                url: url,
                dataType: "json",
                success: function(data) {
                    if (data && typeof(data) == 'object' && 'code_division' in data) {
                        var code_division = data['code_division'];
                        if (code_division !== '') {
                            doss_division_node.value = code_division;
                            $(doss_division_node).trigger('change');
                        }
                    }
                }
            });
        }

        // les champs requis ne sont pas existant ou invalides : on vide le champ
        else {
            doss_division_node.value = '';
            $(doss_division_node).trigger('change');
        }
    }
}

/**
 * Met à jour le numéro de séquence composant la numérotation du dossier.
 *
 * @return void
 */
function update_num_dossier_seq(force = false) {

    // si le champ de la séquence existe
    var num_seq_node = document.getElementById('num_doss_sequence');
    if (num_seq_node) {

        // si la valeur courante du champ est indéfinie, vide, nulle ou zéro
        // on que l'on force la mise à jour du champ
        if (! num_seq_node.value || num_seq_node.value == '0' || force) {

            // récupération des autres champs composant la numérotation
            // nécessaires au calcul de la séquence
            var type_da_node = document.getElementById('num_doss_type_da');
            var code_depcom_node = document.getElementById('num_doss_code_depcom');
            var date_annee_node =  document.getElementById('num_doss_annee');

            // si leur valeur est non-nulle/non-vide/non-indéfinie/non-zéro
            if (type_da_node && code_depcom_node && date_annee_node &&
                    type_da_node.value && code_depcom_node.value && date_annee_node.value &&
                    type_da_node.value != '0' && code_depcom_node.value != '0' &&
                    date_annee_node.value != '0') {

                // récupère l'objet de l'url courante
                var obj = getUrlParamValue('obj', window.location.search);
                if (! obj || (obj != 'demande_nouveau_dossier'
                        && obj != 'demande_nouveau_dossier_contentieux')) {
                    obj = 'demande_nouveau_dossier';
                }

                // défini l'URL permettant de récupérer la valeur courante de la séquence
                var url = '../app/index.php?module=form&obj='+obj+'&action=142'
                    + '&type_da=' + encodeURIComponent(type_da_node.value)
                    + '&code_depcom=' + encodeURIComponent(code_depcom_node.value)
                    + '&date_demande_annee=' + encodeURIComponent(date_annee_node.value);

                // récupération de la valeur de la séquence et mise à jour du champ
                $.ajax({
                    url: url,
                    dataType: "json",
                    success: function(data) {
                        if (data && typeof(data) == 'object' && 'seq_currval' in data) {
                            var num_doss_seq_currval = parseInt(data['seq_currval']);
                            if (num_doss_seq_currval < 9999) {
                                num_seq_node.value = num_doss_seq_currval + 1;
                                $(num_seq_node).trigger('change');
                            }
                            else {
                                console.error(
                                    "Le numéro de séquence reçu '"+ num_doss_seq_currval +"' "+
                                    "est invalide (supérieur ou égal à 9999).");
                            }
                        }
                    }
                });
            }

            // si les champs requis sont inexistant ou leurs valeurs invalides : on vide le champ
            else {
                num_seq_node.value = '';
                $(num_seq_node).trigger('change');
            }
        }
    }
}

/**
 * Met à jour la liste des affectations automatiques (identifiées comme manuelle) possibles d'une nouvelle demande.
 *
 * @param  mixed  _this      L'objet courant
 * @param  func   callback   Une fonction a appeler après que le champ est été mis à jour
 * @param  int    delay_cb   Un délai avant le callback. Uniquemnt si le champ est affiché
 *
 * @return void
 */
function update_affectation_auto(_this = null, callback = null, delay_cb = 0) {

    // champs de l'affectation automatique
    var aff_auto_jq = $('#affectation_automatique');

    // fonction d'appel du callback
    var _cb = function (aff_auto_jq_is_show) {
        if (typeof callback === 'function') {
            if (delay_cb && aff_auto_jq_is_show) {
                setTimeout(function() { callback(_this); }, delay_cb);
            }
            else {
                callback(_this);
            }
        }
    };

    // si aucun champ 'affectation_automatique' on ne fait rien
    if (! aff_auto_jq.exists()) {
        _cb(false);
        return;
    }

    // récupération des informations nécessaires
    var om_collectivite_id = $('#om_collectivite').val();
    var datd_id = $('select#dossier_autorisation_type_detaille').val();
    var demande_type_id = $('#demande_type').val();

    // s'il manque des informations
    if (om_collectivite_id == undefined || om_collectivite_id == ''
        || datd_id == undefined || datd_id == ''
        || demande_type_id == undefined || demande_type_id == '') {

        // on remplace le noeud DOM par un <input> caché et à valeur vide
        aff_auto_jq.replaceWith(
            '<input id="affectation_automatique" name="affectation_automatique" type="hidden" ' +
            'value="" />'
        );

        // on cache la ligne du bloc
        $('#affectation_automatique').parent().parent().hide();

        // on s'arrête là
        _cb(false);
        return;
    }

    // récupère l'objet de l'url courante
    var obj = getUrlParamValue('obj', window.location.search);
    if (! obj || (obj != 'demande_nouveau_dossier'
            && obj != 'demande_nouveau_dossier_contentieux')) {
        obj = 'demande_nouveau_dossier';
    }

    // composition de l"URL permettant de récupérer les affectations automatiques
    var url = '../app/index.php?module=form&obj='+obj+'&action=150'
        + '&om_collectivite=' + encodeURIComponent(om_collectivite_id)
        + '&datd=' + encodeURIComponent(datd_id)
        + '&demande_type=' + encodeURIComponent(demande_type_id);

    // le champ 'commune' existe donc on l'utilise (sous forme de select normal ou autocomplete)
    var commune_node = document.getElementById('commune');
    if (! commune_node) {
        commune_node = document.getElementById('autocomplete-commune-id');
    }
    if (commune_node) {
        var commune_id = commune_node.value
        if (regex_positive_integer.test(commune_id)) {
            url += '&commune=' + encodeURIComponent(commune_id);
        }
    }

    // exécution de la requête HTTP pour récupérer les affectations automatiques
    $.ajax({
        url: url,
        dataType: "json",
        success: function(data) {
            aff_auto_jq = $('#affectation_automatique');

            // si le champ 'affectation_automatique' n'existe plus
            if (! aff_auto_jq) {
                _cb(false);
                return;
            }

            // on cache la ligne du bloc
            aff_auto_jq.parent().parent().hide();

            // on remplace le noeud DOM par un <select>
            var aff_auto_jq_classes = aff_auto_jq.attr('class');
            var urlParams = extractUrlParams();
            var selectedValue = null;
            if ('affectation_automatique' in urlParams) {
                selectedValue = urlParams['affectation_automatique'];
            }
            aff_auto_jq.replaceWith(
                '<select id="affectation_automatique" name="affectation_automatique">' +
                '<option value=""' + (! selectedValue ? ' selected="selected"' : '') + '>' +
                'choisir affectation automatique' +
                '</option>' +
                '</select>'
            );
            aff_auto_jq = $('#affectation_automatique');
            aff_auto_jq.attr('class', aff_auto_jq_classes);

            // si on a bien reçu des affectations automatiques correspondantes
            var options_received = false;
            if (data && typeof(data) == 'object' && 'affectations_auto' in data) {
                var aff_auto = data['affectations_auto'];
                if (aff_auto && typeof(aff_auto) == 'object' && aff_auto.length > 0) {
                    options_received = true;

                    // on les ajoute au <select> en tant que <option>
                    $.each(aff_auto, function() {
                        var opt_html = $("<option></option>").text(this.libelle).val(this.id);
                        if (selectedValue && selectedValue == this.id) {
                            opt_html.attr('selected', 'selected');
                        }
                        aff_auto_jq.append(opt_html);
                    });
                }
            }

            // si on a ajouté des options on affiche la ligne du bloc
            if (options_received) {
                aff_auto_jq.parent().parent().show();

                // exécute le callback avec délai
                _cb(true);
            }
            else {

                // exécute le callback sans délai
                _cb(false);
            }
        }
    });
}

/**
 * Remplace un paramètre d'une URL relative (sans domaine)
 *
 * @source: https://stackoverflow.com/a/20420424
 */
function replaceRelativeUrlParam(url, paramName, paramValue)
{
    if (paramValue == null) {
        paramValue = '';
    }
    var pattern = new RegExp('\\b('+paramName+'=).*?(&|#|$)');
    if (url.search(pattern)>=0) {
        return url.replace(pattern,'$1' + paramValue + '$2');
    }
    url = url.replace(/[?#]$/,'');
    return url + (url.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue;
}

/**
 * Met à jour l'objet 'autocomplete' du champ commune à partir des champs
 * 'om_collectivite' et 'date_demande'
 * (lorsque l'option dossier_commune est activée)
 */
function update_commune_autocomplete() {

    var collectivite_node = document.getElementById('om_collectivite');

    // si le champ 'om_collectivite' existe
    if (collectivite_node) {

        // récupère sa valeur courante
        var current_om_collectivite = collectivite_node.value || '';

        // si le champ 'commune' autocompleté existe
        var communes_auto_node = document.getElementById('autocomplete-commune-search');
        if (communes_auto_node) {

            // récupère la valeur courante de l'url permettant de récupérer les communes
            var currentSrcUrl = $(communes_auto_node).autocomplete('option', 'source');
            if (currentSrcUrl) {

                // analyse cette url pour ajouter/remplacer la collectivité
                var search_params = new URLSearchParams(currentSrcUrl);
                if (search_params) {


                    // récupère la valeur du champ 'date_demande'
                    var date_demande_node = document.getElementById('date_demande');
                    var current_date_demande = date_demande_node.value || '';

                    // récupère la valeur courante du paramètre d'URL 'date_demande'
                    var param_date_demande = search_params.get('date_demande');

                    // récupère la valeur courante du paramètre d'URL 'om_collectivite'
                    var param_om_collectivite = search_params.get('om_collectivite');

                    // si l'un des paramètres d'URL est différent de la valeur du champ
                    // on met à jour l'URL avec la valeur du champ
                    var newSrcUrl = currentSrcUrl;
                    if (current_om_collectivite != param_om_collectivite) {
                        newSrcUrl = replaceRelativeUrlParam(
                            newSrcUrl, 'om_collectivite', current_om_collectivite);
                    }
                    if (current_date_demande != param_date_demande) {
                        newSrcUrl = replaceRelativeUrlParam(
                            newSrcUrl, 'date_demande', current_date_demande);
                    }

                    // mise à jour de l'URL de l'auto-complete et remise à zéro de la sélection
                    if (newSrcUrl != currentSrcUrl) {
                        $(communes_auto_node).autocomplete('option', 'source', newSrcUrl);

                        // Si la valeur actuellement sélectionnée fait partie de la nouvelle
                        // liste des valeurs possibles alors on ne vide pas le champ autocomplete
                        $current_id = $("#autocomplete-commune-id").val();
                        $current_val = $(communes_auto_node).val();
                        if ($current_id !== '' && $current_id !== null
                            && $current_val.trim() !== '' && $current_val.trim() !== null) {
                            //
                            $.ajax({
                                type: "GET",
                                url: newSrcUrl+'&term='+$(communes_auto_node).val(),
                                dataType: 'json',
                                success: function(data) {
                                    if (data.some(item => item.value === $current_id) === false) {
                                        clear_autocomplete('autocomplete-commune');
                                        // Récupère un message traduit en PHP
                                        $.ajax({
                                            type: "GET",
                                            url: "../app/index.php?module=form&obj=demande_nouveau_dossier&action=170&idx=0&text_choice=commune_change_selection",
                                            success: function(message) {
                                                if (message) {
                                                    alert(message);
                                                }
                                            }
                                        });
                                    }
                                }
                            });
                        }
                    }
                }
                else {
                    console.error("L'objet autocomplete du champ 'commune' a une source invalide.");
                }
            }
            else {
                console.error("L'objet autocomplete du champ 'commune' devrait avoir une source déjà définie.");
            }
        }
    }
}


/**
 *
 * @return void
 */
function view_document_numerise_preview_edition() {
    //
    $("#frame_pdf").height($('#sousform-document_numerise_preview_edition').height()-50);
    $("#frame_pdf").width($('#sousform-document_numerise_preview_edition').width()-50);
    $('#sousform-document_numerise_preview_edition .formControls input').hide();
    $('#sousform-document_numerise_preview_edition .formControls-bottom').hide();
}

/**
 *
 * @return void
 */
 function view_instruction_preview_edition() {
    //
    $("#frame_pdf").height($('#sousform-instruction_preview_edition').height()-50);
    $("#frame_pdf").width($('#sousform-instruction_preview_edition').width()-50);
    $('#sousform-instruction_preview_edition .formControls input').hide();
    $('#sousform-instruction_preview_edition .formControls-bottom').hide();
}

/**
 *
 * @return void
 */
 function view_rapport_instruction_preview_edition() {
    //
    $("#frame_pdf").height($('#sousform-rapport_instruction_preview_edition').height()-50);
    $("#frame_pdf").width($('#sousform-rapport_instruction_preview_edition').width()-50);
    $('#sousform-rapport_instruction_preview_edition .formControls input').hide();
    $('#sousform-rapport_instruction_preview_edition .formControls-bottom').hide();
}

/**
 *
 * @return void
 */
 function view_storage_preview_edition() {
    //
    $("#frame_pdf").height($('#sousform-storage_preview_edition').height()-50);
    $("#frame_pdf").width($('#sousform-storage_preview_edition').width()-50);
    $('#sousform-storage_preview_edition .formControls input').hide();
    $('#sousform-storage_preview_edition .formControls-bottom').hide();
}

/**
 *
 * @return void
 */
 function view_consultation_preview_edition() {
    //
    $("#frame_pdf").height($('#sousform-consultation_preview_edition').height()-50);
    $("#frame_pdf").width($('#sousform-consultation_preview_edition').width()-50);
    $('#sousform-consultation_preview_edition .formControls input').hide();
    $('#sousform-consultation_preview_edition .formControls-bottom').hide();
}
/**
 * Renvoi la valeur du paramètre GET de l'url passée en argument, ou 'false' si non-trouvé
 *
 */
function getUrlParamValue(key, url = null) {
    if (url === null) {
        url = window.location.search;
    }
    var search_params = new URLSearchParams(url);
    if (search_params) {
        return search_params.get(key);
    }
    return false;
}

/**
 * Surcharge de la méthode form_container_refresh qui
 * utilise les données récupérée à partir du href de la balise d'id sousform-real-href plutot
 * que celle du sousform-href pour mettre à jour les données de la page.
 *
 * Dans le cas ou un listing est affiché en dessous d'un formulaire en consultation,
 * cette modification permet d'afficher le code complet de la page et pas uniquement
 * celui du tableau.
 * Le problème étant que le tableau à lui aussi une balise d'id sousform-href et que
 * c'est le href qui lui est associé qui va être utilisé car cette balise est affichée
 * en première.
 */
 function form_container_refresh(elem) {
    //
    if (elem == "form") {
        //
        $.get(window.location.href, function(data) {
            //
            $('#form-container').html(data);
            // Initialisation JS du nouveau contenu de la page
            om_initialize_content();
        });
    } else if (elem == "sousform") {
        //
        if($("#sousform-real-href").attr('data-href') !== null && 
            $("#sousform-real-href").attr('data-href') !== undefined && 
            $("#sousform-real-href").attr('data-href') !== ''
            ){

            $.get($("#sousform-real-href").attr('data-href')+"&contentonly=true", function(data) {
                //
                $('#sousform-container').html(data);
                // Initialisation JS du nouveau contenu de la page
                om_initialize_content();
            });
        }
    }
}

/**
 * Affiche le champ description_type dans le formulaire d'ajout des pièces
 * si le champ Autre à préciser est sélectionné.
 * Si un autre type de pièce est choisi, masque le champ et supprime son
 * contenu
 *
 */
 function afficheChampDescription(selectedValue, idPieceAutre) {
    if (selectedValue == idPieceAutre) {
        $('input#description_type').parents('div.field-type-hidden').attr('class', 'field field-type-text');
        document.getElementById('description_type').type = 'text';
        $('input#description_type').val("");
    } else {
        document.getElementById('description_type').type = 'hidden';
        $('input#description_type').val("");
        $('input#description_type').parents('div.field-type-text').attr('class', 'field field-type-hidden');
    }
}

/**
 * Permet de mettre à jour le formulaire d'instruction après validation
 * du formulaire de sélection des demandeurs.
 *
 */
function validation_formulaire_notification_manuelle() {
    // Refresh du formulaire de l'instruction
    form_container_refresh("sousform");
}

/**
 * Récupérer le numéro du dossier courant et de l'instructeur sélecionné.
 * A partir de ces informations interroge le serveur à l'aide d'une ajax
 * pour récupérer l'identifiant de la division de l'instructeur.
 * Donne au select du champ division la valeur ainsi récupérée.
 *
 * @param {integer} idInstructeur identifiant de l'instructeur sélectionné
 * @param {string} idDossier identifiant du dossier courant
 */
function changementDivision(idInstructeur,idDossier) {
    // Lien servant à appeller l'action qui permet de récupérer l'identifiant de la division
    // à l'aide de l'identifiant de l'instructeur contenu dans "instructeurId"
    link = "../app/index.php?module=form&obj=dossier_instruction&action=599&idx=" + idDossier + "&instructeurId=" + idInstructeur;
    // Traitement
    $.ajax({
        type: "GET",
        url: link,
        cache: false,
        dataType: "json",
        success: function(data) {
            // Le select du champ division prend la valeur récupérer via l'action
            $("#division").val(data["division"]);
        },
        async: false,
    });
}

/**
 * Surcharge de ajaxIt pour ajouter un spinner au chargement de la page.
 *
 * @param {string} objsf nom du sous formulaire ex: document_numerise
 * @param {string} link url permettant de récupérer les infos du formulaire
 */
function ajaxIt(objsf, link) {
    $("#sousform-"+objsf).append(msg_loading);
    // execution de la requete en POST
    $.ajax({
        type: "GET",
        url: link,
        cache: false,
        success: function(html){
            $("#sousform-"+objsf).empty();
            $("#sousform-"+objsf).append(html);
            real_link = $(html).find("#sousform-real-href").attr("data-href");
            if ($("#sousform-href").length) {
                if (real_link != undefined) {
                    $("#sousform-href").attr("data-href", real_link);
                } else {
                    $("#sousform-href").attr("data-href", link);
                }
            }
            om_initialize_content(true);
        }
    });
}

/**
 * SURCHARGE/OVERLOAD - lib/om-assets/js/layout_jqueryui_after.js
 *
 * FORM WIDGET - HTML tinyMCE Complet pour les états et lettre type
 *
 * Le surcharge permet d'ajouter la police de caractère Arial.
 *
 * CORPS
 */
function inputText_bind_tinyMCE_extended() {
    //
    tinymce.init({
        //
        selector: "textarea.htmletatex",
        //
        menubar: "edit insert format table tools",
        //
        menu: {
            edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall | searchreplace'},
            insert: {title: 'Insert', items: 'sousetats | hr pagebreak | insertdatetime'},
            format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | removeformat'},
            table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
            tools: {title: 'Tools', items: 'code | fullscreen'}
        },
        // modifier le language via l'appel à la LOCALE
        language : locale,
        // Spell check (pas de contextmenu...)
        browser_spellcheck : true,
        //
        fontsize_formats: "6pt 7pt 8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 18pt 24pt 36pt",
        entity_encoding : "raw",
        plugins: [
            "advlist lists hr pagebreak",
            "searchreplace wordcount fullscreen",
            "insertdatetime save table",
            "paste textcolor autoresize code"
        ],
        // Custom CSS
        content_css: "../lib/om-assets/css/tinymce.css",
        // Style inline
        inline_styles : true,
        paste_auto_cleanup_on_paste : true,
        paste_word_valid_elements: "b,strong,i,em,h1,h2",
        //
        contextmenu : "cut copy paste pastetext selectall | removeformat | insertdate inserttable",
        insertdatetime_formats : ["%d/%m/%Y", "%H:%M"],
        tools: "inserttable",
        debug : true,
        pagebreak_separator : "<br pagebreak='true' />",
        // table_unbreakable_breakable_property - Ajout de l'attribut nobr sur
        // l'élement table comme élément valide pour ne pas qu'il soit supprimé
        // par tinymce (tous les attributs existants de table ont été repris
        // car le paramètre 'extended_valid_elements' n'étend pas l'existant
        // sur une balise).
        extended_valid_elements : "br[pagebreak],table[nobr|border=0|style|cellspacing|cellpadding|width|frame|rules|height|align|summary|bgcolor|background|bordercolor],",
        invalid_elements : "script,applet,iframe,tcpdf",
        toolbar1: "undo redo | bold italic underline | fontselect |"+
        " fontsizeselect | alignleft aligncenter alignright alignjustify |"+
        " bullist numlist | forecolor backcolor | majmin | codebarre | table_unbreakable_breakable_property",
        formats : {
            bold: {inline: 'span',  styles: {'font-weight': 'bold'}},
            mce_minformat: {inline: 'span', 'classes': 'mce_min'},
            mce_majformat: {inline: 'span', 'classes': 'mce_maj'},
            mce_codebarreformat: {inline: 'span', 'classes': 'mce_codebarre'},
        },

        // Liste des polices
        font_formats: "Courier New=courier new,courier;"+
            "Helvetica=helvetica;"+
            "Times New Roman=times new roman,times;"+
            "Arial=arial",

        // Interdiction de redimentionner une table
        object_resizing : false,
        // Colle le texte brut sans style, ni balise
        paste_as_text: true,
        //
        setup: function (editor) {
            //
            addMajMinButton(editor);
            // table_unbreakable_breakable_property - Ajout du bouton.
            tinymce_add_table_unbreakable_breakable_property(editor);
            //
            addCodeBarreButton(editor);
            //
            addSEMenu(editor);
            //
            editor.on('SetContent', function(e) {
                editor.save();
            });
        }
    });
}

/**
 * SURCHARGE/OVERLOAD - lib/om-assets/js/layout_jqueryui_after.js
 *
 * FORM WIDGET - HTML Simplifié - Zones de texte des formulaires
 *
 * Le surcharge permet d'ajouter la police de caractère Arial.
 *
 * CHAMPS DE FUSION
 */
function inputText_bind_tinyMCE() {
    //
    tinymce.init({
        //
        selector: "textarea.html",
        //
        menubar: "edit insert format table tools",
        //
        menu: {
            edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall | searchreplace'},
            insert: {title: 'Insert', items: 'hr | insertdatetime'},
            format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | removeformat'},
            table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
            tools: {title: 'Tools', items: 'code | fullscreen'}
        },
        // modifier le language via l'appel à la LOCALE
        language : locale,
        // Spell check (pas de contextmenu...)
        browser_spellcheck : true,
        //
        fontsize_formats: "6pt 7pt 8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 18pt 24pt 36pt",
        entity_encoding : "raw",
        plugins: [
            "advlist lists hr",
            "searchreplace wordcount",
            "insertdatetime save",
            "paste textcolor autoresize code"
        ],
        // Custom CSS
        content_css: "../lib/om-assets/css/tinymce.css",
        // Style inline
        inline_styles : true,
        paste_auto_cleanup_on_paste : true,
        paste_word_valid_elements: "b,strong,i,em,h1,h2",
        //
        contextmenu : "cut copy paste pastetext selectall | removeformat | insertdate",
        insertdatetime_formats : ["%d/%m/%Y", "%H:%M"],
        invalid_elements : "script,applet,iframe,tcpdf",
        toolbar1: "undo | bold italic underline | fontselect | "+
            " fontsizeselect | alignleft aligncenter alignright alignjustify |"+
            " bullist numlist | forecolor backcolor",

        formats : {
            bold: {inline: 'span',  styles: {'font-weight': 'bold'}},
        },

        // Liste des polices
        font_formats: "Courier New=courier new,courier;"+
            "Helvetica=helvetica;"+
            "Times New Roman=times new roman,times;"+
            "Arial=arial",

        // Colle le texte brut sans style, ni balise
        paste_as_text: true,
        //
        setup: function(editor) {
            //
            editor.on('SetContent', function(e) {
                editor.save();
            });
        }
    });
}

/**
 * SURCHARGE/OVERLOAD - lib/om-assets/js/layout_jqueryui_after.js
 *
 * FORM WIDGET - HTML Simplifié pour champs de fusions des états et lettretype
 *
 * Le surcharge permet d'ajouter la police de caractère Arial.
 *
 * TITRE, HEADER, FOOTER
 */
function inputText_bind_tinyMCE_simple() {
    //
    tinymce.init({
        //
        selector: "textarea.htmletat",
        //
        menubar: "edit insert view format table tools",
        //
        menu: {
            edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall | searchreplace'},
            insert: {title: 'Insert', items: 'hr | insertdatetime | template'},
            format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | removeformat'},
            table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
            tools: {title: 'Tools', items: 'code | fullscreen'}
        },
        // modifier le language via l'appel à la LOCALE
        language : locale,
        // Spell check (pas de contextmenu...)
        browser_spellcheck : true,
        //
        fontsize_formats: "6pt 7pt 8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 18pt 24pt 36pt",
        entity_encoding : "raw",
        plugins: [
            "advlist lists hr",
            "searchreplace wordcount fullscreen",
            "insertdatetime save table",
            "template paste textcolor autoresize code"
        ],
        // Custom CSS
        content_css: "../lib/om-assets/css/tinymce.css",
        // Style inline
        inline_styles : true,
        paste_auto_cleanup_on_paste : true,
        paste_word_valid_elements: "b,strong,i,em,h1,h2",
        //
        contextmenu : "cut copy paste pastetext selectall | removeformat | insertdate inserttable",
        insertdatetime_formats : ["%d/%m/%Y", "%H:%M"],
        tools: "inserttable",
        invalid_elements : "script,applet,iframe,tcpdf",
        toolbar1: "undo redo | bold italic underline | fontselect |"+
        " fontsizeselect | alignleft aligncenter alignright alignjustify |"+
        " bullist numlist | forecolor backcolor | majmin | codebarre | fullscreen",
        templates: [
            {title: 'Modèle courrier', content: '<p>&nbsp;</p><table><tbody><tr><td style=\'width: 50%;\'><p>Civilit&eacute; Nom Pr&eacute;nom emetteur</p><p>adresse</p><p>compl&eacute;ment</p><p>cp ville</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p></td><td><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>Civilit&eacute; Nom Pr&eacute;nom destinataire</p><p>adresse</p><p>compl&eacute;ment</p><p>cp ville</p></td></tr></tbody></table>'}            ],

        formats : {
            bold: {inline: 'span',  styles: {'font-weight': 'bold'}},
            mce_minformat: {inline: 'span', 'classes': 'mce_min'},
            mce_majformat: {inline: 'span', 'classes': 'mce_maj'},
            mce_codebarreformat: {inline: 'span', 'classes': 'mce_codebarre'},
        },

        // Liste des polices
        font_formats: "Courier New=courier new,courier;"+
            "Helvetica=helvetica;"+
            "Times New Roman=times new roman,times;"+
            "Arial=arial",

        // Interdiction de redimentionner une table
        object_resizing : false,
        // Colle le texte brut sans style, ni balise
        paste_as_text: true,
        //
        setup: function (editor) {
            //
            addMajMinButton(editor);
            //
            addCodeBarreButton(editor);
            //
            editor.on('SetContent', function(e) {
                editor.save();
            });
        }
    });
}

/**
 * Alterne l'affichage de la liste des champs passé en paramètre
 * selon si la condition voulue est remplie ou pas.
 *
 * @param {boolean} condition
 * @param {array} afficheSiOK liste des champs affiché si la condition est respectée
 * @param {array} afficheSiNon Liste des champs affiché si la condition n'est pas
 * respecté
 */
function alternate_display(condition, afficheSiOK, afficheSiNon) {
    if (condition) {
        afficheSiOK.forEach(displayField);
        afficheSiNon.forEach(hideField);
        return;
    }
    afficheSiNon.forEach(displayField)
    afficheSiOK.forEach(hideField)
}

/**
 * Masque un champs de formulaire en lui donnant pour type hidden.
 * @param {string} fieldName identifiant du champs à cacher 
 */
function hideField(fieldName) {
    $('#' + fieldName).parents('.field').addClass('ui-tabs-hide')
    // Vide la valeur du champs masqué
    $('#' + fieldName).val('').removeAttr('checked').removeAttr('selected');
}

/**
 * Affiche un champs caché en lui retirant sa classe hidden.
 * @param {string} fieldName identifiant du champs à cacher 
 */
 function displayField(fieldName) {
    $('#' + fieldName).parents('.field').removeClass('ui-tabs-hide')
}

/**
 * Mutateur de la valeur d'un champ et déclenche son événement de changement (onchange).
 *
 * @param {object} target Objet visé.
 * @param {string} value  Valeur de l'objet visé.
 */
function set_field_value(target, value) {
    target.value = value;
    target.onchange();
}

/**
 * Permet de faire un calcul simplifié et sauvegardé le résultat dans la valeur d'un champ.
 * Simplifié dans le sens où l'opérateur se mettra entre chaque opérande de façon itérative.
 * Exemple pour une division avec 3 opérandes 10, 4, 8.
 * Le résultat sera 10 / 4 = 2.5, puis 2.5 / 8 = 0,3125.
 * Donc le résultat final sera 0.3125.
 *
 * @param  {object} target   Objet visé.
 * @param  {string} operator Opérateur du calcul (addition, subtraction, division, multiplication).
 * @param  {[type]} operands Opérandes composant le calcul.
 */
function calculate_field_value(target, operator, operands) {
    // Si un opérande n'est pas définit alors le calcul n'est pas exécuté
    operands.forEach(function(item, index, array) {
        if (item === '') {
            return;
        }
    });

    // Par défaut le résultat prend le premier opérande
    result = parseFloat(operands[0]);
    if (operator === 'addition') {
        operands.forEach(function(item, index, array) {
            if (index !== 0 && isNaN(item) !== true) {
                result += parseFloat(item);
            }
        });
    }
    if (operator === 'subtraction') {
        operands.forEach(function(item, index, array) {
            if (index !== 0 && isNaN(item) !== true) {
                result -= parseFloat(item);
            }
        });
    }
    if (operator === 'division') {
        operands.forEach(function(item, index, array) {
            if (index !== 0 && isNaN(item) !== true) {
                // Gestion de la division par 0
                if (parseFloat(item) === 0) {
                    result = 0;
                } else {
                    result /= parseFloat(item);
                }
            }
        });
    }
    if (operator === 'multiplication') {
        operands.forEach(function(item, index, array) {
            if (index !== 0 && isNaN(item) !== true) {
                result *= parseFloat(item);
            }
        });
    }

    // Le résutat doit être un numérique pour mettre à jour la cible
    // et déclencher sont onchange
    if (isNaN(result) !== true) {
        target.value = result;
        target.onchange();
    }
}

// SURCHAGE afin de modifier l'icone des datepicker
function inputdate_bind_datepicker() {
    //
    $(".datepicker").datepicker({
        dateFormat: dateFormat,
        changeMonth: true,
        changeYear: true,
        yearRange: minYear+':'+maxYear,
        showOn: "button",
        buttonImage: './img/calendar-16x16.svg',
        buttonImageOnly: true,
        buttonText: "Choisir une date",
        constrainInput: true
    });
}

// ***
// Ajout d'une deuxième scrollbar quand le tableau est dans un petit écran
// ***

$(function(){
    $(".wrapper1").scroll(function(){
        $(".wrapper2")
            .scrollLeft($(".wrapper1").scrollLeft());
    });
    $(".wrapper2").scroll(function(){
        $(".wrapper1")
            .scrollLeft($(".wrapper2").scrollLeft());
    });
});
