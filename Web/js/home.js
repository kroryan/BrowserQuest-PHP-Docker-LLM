define(['lib/class', 'lib/underscore.min', 'lib/stacktrace', 'util'], function() {
    require(["jquery", "i18n"], function($, i18n) {
        
        // Función para actualizar el estado visual del selector de idioma
        function updateLanguageSelector() {
            // Actualizar selector pequeño
            $('#language-selector .lang-option').removeClass('active');
            $('#language-selector .lang-option[data-lang="' + i18n.currentLang + '"]').addClass('active');
            
            // Actualizar botones grandes
            $('#language-buttons .lang-button').removeClass('active');
            $('#language-buttons .lang-button[data-lang="' + i18n.currentLang + '"]').addClass('active');
        }
        
        // Función para cambiar el idioma
        function changeLanguage(newLang) {
            // Cambiar el idioma
            i18n.setLanguage(newLang, function() {
                // Actualizar el selector de idioma
                updateLanguageSelector();
                
                // Aplicar las traducciones
                if (window.app) {
                    app.translateUI();
                }
                
                // Ocultar los botones grandes después de seleccionar
                $('#language-buttons').fadeOut(500);
                
                // Mostrar el parchment después de cambiar el idioma
                if ($('#parchment').css('opacity') === '0') {
                    $('#parchment').css('opacity', 1);
                }
            });
        }
        
        // Inicializar el sistema de traducción y luego cargar el resto de la aplicación
        i18n.init(function() {
            i18n.translateDOM();
            
            // Configurar el selector de idioma
            updateLanguageSelector();
            
            // Si hay un idioma preferido guardado, ocultar los botones grandes
            if (localStorage.getItem('bq_language')) {
                $('#language-buttons').hide();
            } else {
                // Si no hay idioma seleccionado previamente, ocultar el parchment hasta que se seleccione un idioma
                $('#parchment').css('opacity', 0);
            }
            
            // Manejar clics en las opciones de idioma del selector pequeño
            $('#language-selector .lang-option').click(function() {
                var newLang = $(this).data('lang');
                changeLanguage(newLang);
            });
            
            // Manejar clics en los botones grandes de idioma
            $('#language-buttons .lang-button').click(function() {
                var newLang = $(this).data('lang');
                changeLanguage(newLang);
            });
            
            // Cargar el resto de la aplicación
            require(["main"]);
        });
    });
});