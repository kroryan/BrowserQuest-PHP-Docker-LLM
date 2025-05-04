define(['jquery'], function($) {
    var i18n = {
        currentLang: 'en',
        translations: {},
        
        /**
         * Inicializa el sistema de traducción
         */
        init: function(callback) {
            var self = this;
            
            // Verificar si hay un idioma guardado en localStorage
            var savedLang = localStorage.getItem('bq_language');
            if (savedLang) {
                this.currentLang = savedLang;
            } else {
                // Si no hay preferencia guardada, intentar detectar el idioma del navegador
                var userLang = navigator.language || navigator.userLanguage;
                this.currentLang = userLang.startsWith('es') ? 'es' : 'en';
            }
            
            // Cargar archivo de traducción
            this.loadLanguage(this.currentLang, callback);
        },
        
        /**
         * Carga un archivo de idioma
         */
        loadLanguage: function(lang, callback) {
            var self = this;
            
            $.getJSON('i18n/' + lang + '.json', function(data) {
                self.translations = data;
                self.currentLang = lang;
                
                // Guardar preferencia en localStorage
                localStorage.setItem('bq_language', lang);
                
                if (callback) {
                    callback();
                }
            });
        },
        
        /**
         * Cambia el idioma actual y recarga la interfaz
         */
        setLanguage: function(lang, callback) {
            if (lang === this.currentLang) {
                if (callback) callback();
                return;
            }
            
            var self = this;
            this.loadLanguage(lang, function() {
                // Traducir la interfaz con el nuevo idioma
                self.translateDOM();
                
                // Ejecutar callback si existe
                if (callback) callback();
            });
        },
        
        /**
         * Obtiene una traducción por su clave
         * Soporta rutas anidadas con notación de puntos (ej: "ui.death.message")
         */
        get: function(key, params) {
            var keys = key.split('.');
            var value = this.translations;
            
            // Navegar por el objeto de traducciones
            for (var i = 0; i < keys.length; i++) {
                if (value[keys[i]] === undefined) {
                    return key; // Devolver la clave si no se encuentra la traducción
                }
                value = value[keys[i]];
            }
            
            // Si es un array, convertirlo a string
            if (Array.isArray(value)) {
                return value;
            }
            
            // Reemplazar parámetros si existen (%1, %2, etc.)
            if (params && typeof value === 'string') {
                for (var i = 0; i < params.length; i++) {
                    value = value.replace('%' + (i + 1), params[i]);
                }
            }
            
            return value;
        },
        
        /**
         * Traduce dinámicamente los elementos del DOM
         */
        translateDOM: function() {
            $('[data-i18n]').each(function() {
                var $element = $(this);
                var key = $element.data('i18n');
                var translation = i18n.get(key);
                
                if (typeof translation === 'string') {
                    $element.html(translation);
                }
            });
            
            $('[data-i18n-placeholder]').each(function() {
                var $element = $(this);
                var key = $element.data('i18n-placeholder');
                var translation = i18n.get(key);
                
                if (typeof translation === 'string') {
                    $element.attr('placeholder', translation);
                }
            });
        }
    };
    
    // Export i18n to make it globally accessible for sending the language to the server
    window.i18n = i18n;
    
    return i18n;
});