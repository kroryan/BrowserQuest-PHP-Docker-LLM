<!DOCTYPE html>
<!-- 

 , __                                   __                      
/|/  \                                 /  \                     
 | __/ ,_    __           ,   _   ,_  | __ |          _   , _|_ 
 |   \/  |  /  \_|  |  |_/ \_|/  /  | |/  \|  |   |  |/  / \_|  
 |(__/   |_/\__/  \/ \/   \/ |__/   |_/\__/\_/ \_/|_/|__/ \/ |_/

Mozilla presents an HTML5 mini-MMORPG by Little Workshop http://www.littleworkshop.fr

* Client libraries used: RequireJS, Underscore.js, jQuery, Modernizr
* Server-side: Node.js, Worlize/WebSocket-Node, miksago/node-websocket-server
* Should work in latest versions of Firefox, Chrome, Safari, Opera, Safari Mobile and Firefox for Android

 -->
<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=1">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="viewport" content="width=device-width, initial-scale=0.56, maximum-scale=0.56, user-scalable=no">
        <link rel="icon" type="image/png" href="img/common/favicon.png">
        <meta property="og:title" content="BrowserQuest">
        <meta property="og:type" content="website">
        <meta property="og:url" content="http://browserquest.mozilla.org/">
        <meta property="og:image" content="http://browserquest.mozilla.org/img/common/promo-title.jpg">
        <meta property="og:site_name" content="BrowserQuest">
        <meta property="og:description" data-i18n="ui.description">Play Mozilla's BrowserQuest, an HTML5 massively multiplayer game demo powered by WebSockets!</meta>
        <link rel="stylesheet" href="css/main.css" type="text/css">
        <link rel="stylesheet" href="css/achievements.css" type="text/css">
        <script src="js/lib/modernizr.js" type="text/javascript"></script>
        <!--[if lt IE 9]>
                <link rel="stylesheet" href="css/ie.css" type="text/css">
                <script src="js/lib/css3-mediaqueries.js" type="text/javascript"></script>
                <script type="text/javascript">
                document.getElementById('parchment').className = ('error');
                </script>
        <![endif]-->
        <script src="js/detect.js" type="text/javascript"></script>
        <title>BrowserQuest</title>
	</head>
    <!--[if lt IE 9]>
	<body class="intro upscaled">
    <![endif]-->
	<body class="intro">
	    <noscript>
	       <div class="alert" data-i18n="ui.noscript">
	           You need to enable JavaScript to play BrowserQuest.
	       </div>
	    </noscript>
	    <a id="moztab" class="clickable" target="_blank" href="http://www.mozilla.org/"></a>
	    
	    <!-- Selector de idioma -->
	    <div id="language-selector">
	        <div class="lang-option" data-lang="es">ES</div>
	        <div class="lang-option" data-lang="en">EN</div>
	    </div>
	    
	    <!-- Botones de idioma grandes -->
	    <div id="language-buttons">
	        <div class="lang-button" data-lang="es">Español</div>
	        <div class="lang-button" data-lang="en">English</div>
	    </div>
	    
	    <div id="intro">
	        <h1 id="logo">
	           <span id="logosparks">
	               
	           </span>
	        </h1>
	        <article id="portrait">
	            <p data-i18n="ui.rotate_device">
	               Please rotate your device to landscape mode
	            </p>
	            <div id="tilt"></div>
	        </article>
	        <section id="parchment" class="createcharacter">
	            <div class="parchment-left"></div>
	            <div class="parchment-middle">
                    <article id="createcharacter">
          	           <h1>
          	               <span class="left-ornament"></span>
          	               <span data-i18n="ui.create_character.title">A Massively Multiplayer Adventure</span>
          	               <span class="right-ornament"></span>
                         </h1>
                         <div id="character" class="disabled">
                             <div></div>
                         </div>
                         <form action="none" method="get" accept-charset="utf-8">
                             <input type="text" id="nameinput" class="stroke" name="player-name" data-i18n-placeholder="ui.create_character.name_placeholder" placeholder="Name your character" maxlength="15">
                         </form>
                         <div class="play button disabled">
                             <div data-i18n="ui.create_character.button">Play</div>
                             <img src="img/common/spinner.gif" alt="">
                         </div>
                         <div class="ribbon">
                            <div class="top"></div>
                            <div class="bottom"></div>
                         </div>
                    </article>
                    <article id="loadcharacter">
          	           <h1>
          	               <span class="left-ornament"></span>
          	               <span data-i18n="ui.load_character.title">Load your character</span>
          	               <span class="right-ornament"></span>
                         </h1>
                         <div class="ribbon">
                            <div class="top"></div>
                            <div class="bottom"></div>
                         </div>
                         <img id="playerimage" src="">
                         <div id="playername" class="stroke">
                         </div>
                         <div class="play button">
                             <div data-i18n="ui.create_character.button">Play</div>
                             <img src="img/common/spinner.gif" alt="">
                         </div>
                         <div id="create-new">
                            <span><span>or</span> <span data-i18n="ui.load_character.or_create_new">create a new character</span></span>
                         </div>
                    </article>
                    <article id="confirmation">
          	           <h1>
          	               <span class="left-ornament"></span>
          	               <span data-i18n="ui.delete_character.title">Delete your character?</span>
          	               <span class="right-ornament"></span>
                         </h1>
                         <p>
                             <span data-i18n="ui.delete_character.confirm">All your items and achievements will be lost.<br>Are you sure you wish to continue?</span>
                         </p>
                         <div class="delete button" data-i18n="ui.delete_character.button">Delete</div>
                         <div id="cancel">
                            <span data-i18n="ui.delete_character.cancel">cancel</span>
                         </div>
                    </article>
    	            <article id="credits">
        	            <h1>
         	               <span class="left-ornament"></span>
         	               <span class="title" data-i18n="ui.credits.title">
         	                   Made for Mozilla by <a target="_blank" class="stroke clickable" href="http://www.littleworkshop.fr/">Little Workshop</a>
         	               </span>
         	               <span class="right-ornament"></span>
                        </h1>
                        <div id="authors">
                            <div id="guillaume">
                                <div class="avatar"></div>
                                <span data-i18n="ui.credits.pixels_by">Pixels by</span>
                                <a class="stroke clickable" target="_blank" href="http://twitter.com/glecollinet">Guillaume Lecollinet</a>
                            </div>
                            <div id="franck">
                                <div class="avatar"></div>
                                <span data-i18n="ui.credits.code_by">Code by</span>
                                <a class="stroke clickable" target="_blank" href="http://twitter.com/whatthefranck">Franck Lecollinet</a>
                            </div>
                        </div>
                        <div id="seb">
                            
                            <span id="note"></span>
                            <span data-i18n="ui.credits.music_by">Music by</span> <a class="clickable" target="_blank" href="http://soundcloud.com/gyrowolf/sets/gyrowolfs-rpg-maker-music-pack/">Gyrowolf</a>, <a class="clickable" target="_blank" href="http://blog.dayjo.org/?p=335">Dayjo</a>, <a class="clickable" target="_blank" href="http://soundcloud.com/freakified/what-dangers-await-campus-map">Freakified</a>, &amp; <a target="_blank" class="clickable" href="http://www.newgrounds.com/audio/listen/349734">Camoshark</a>
                           
                        </div>
	                    <div id="close-credits">
	                        <span data-i18n="ui.credits.close">- click anywhere to close -</span>
                        </div>
    	            </article>
    	            <article id="about">
        	            <h1>
         	               <span class="left-ornament"></span>
         	               <span class="title" data-i18n="ui.about.title">
         	                   What is BrowserQuest?
         	               </span>
         	               <span class="right-ornament"></span>
                        </h1>
                        <p id="game-desc" data-i18n="ui.about.description">
                            BrowserQuest is a multiplayer game inviting you to explore a
                            world of adventure from your Web browser.
                        </p>
                        <div class="left">
                            <div class="img"></div>
                            <p data-i18n="ui.about.technology">
                                This demo is powered by HTML5 and WebSockets, which allow for real-time gaming and apps on the Web.
                            </p>
                            <span class="link">
                                <span class="ext-link"></span>
                                <a target="_blank" class="clickable" href="http://hacks.mozilla.org/2012/03/browserquest/"><span data-i18n="ui.about.learn_more">Learn more</span></a> <span data-i18n="ui.about.learn_more_about">about the technology</span>
                            </span>
                        </div>
                        <div class="right">
                            <div class="img"></div>
                            <p data-i18n="ui.about.compatibility">
                                BrowserQuest is available on Firefox, Chrome, Safari as well as iOS devices and Firefox for Android.
                            </p>
                            <span class="link">
                                <span class="ext-link"></span>
                                <a target="_blank" class="clickable" href="http://github.com/mozilla/BrowserQuest"><span data-i18n="ui.about.source_code">Grab the source</span></a> <span data-i18n="ui.about.source_on_github">on Github</span>
                            </span>
                        </div>
	                    <div id="close-about">
	                        <span data-i18n="ui.about.close">- click anywhere to close -</span>
                        </div>
    	            </article>
    	            <article id="death">
                        <p data-i18n="ui.death.message">You are dead...</p>
    					<div id="respawn" class="button" data-i18n="ui.death.button">Respawn</div>
    	            </article>
                    <article id="error">
          	           <h1>
          	               <span class="left-ornament"></span>
          	               <span data-i18n="ui.error.title">Your browser cannot run BrowserQuest!</span>
          	               <span class="right-ornament"></span>
                         </h1>
                         <p data-i18n="ui.error.description">
                             We're sorry, but your browser does not support WebSockets.<br>
                             In order to play, we recommend using the latest version of Firefox, Chrome or Safari.
                         </p>
                    </article>
	            </div>
	            <div class="parchment-right"></div>
	        </section>
	    </div>
		<div id="container">
		    <div id="canvasborder">
		        <article id="instructions" class="clickable">
		            <div class="close"></div>
		            <h1>
     	               <span class="left-ornament"></span>
     	               <span data-i18n="ui.instructions.title">How to play</span>
     	               <span class="right-ornament"></span>
	                </h1>
	                <ul>
	                   <li><span class="icon"></span><span data-i18n="ui.instructions.instructions.0">Left click or tap to move, attack and pick up items.</span></li>
	                   <li><span class="icon"></span><span data-i18n="ui.instructions.instructions.1">Press ENTER to chat.</span></li>
	                   <li><span class="icon"></span><span data-i18n="ui.instructions.instructions.2">Your character is automatically saved as you play.</span></li>
	                </ul>
                    <p data-i18n="ui.instructions.close">- click anywhere to close -</p>
		        </article>
		        <article id="achievements" class="page1 clickable">
		            <div class="close"></div>
		            <div id="achievements-wrapper">
		                <div id="lists">
        		        </div>
    		        </div>
    		        <div id="achievements-count" class="stroke">
    		            <span data-i18n="ui.achievements.completed">Completed</span>
    		            <div>
    		                <span id="unlocked-achievements">0</span>
    		                /
    		                <span id="total-achievements"></span>
    		            </div> 
    		        </div>
		            <nav class="clickable">
		                <div id="previous"></div>
		                <div id="next"></div>
		            </nav>
		        </article>
    			<div id="canvas">
    				<canvas id="background"></canvas>
    				<canvas id="entities"></canvas>
    				<canvas id="foreground" class="clickable"></canvas>
    			</div>
    			<div id="bubbles">				
    			</div>
    			<div id="achievement-notification">
    			    <div class="coin">
    			        <div id="coinsparks"></div>
    			    </div>
    			    <div id="achievement-info">
        			    <div class="title" data-i18n="ui.achievements.new">New Achievement Unlocked!</div>
        			    <div class="name"></div>
    			    </div>
    			</div>
    			<div id="bar-container">
					<div id="healthbar">
					</div>
					<div id="hitpoints">
					</div>
					<div id="weapon"></div>
					<div id="armor"></div>
					<div id="notifications">
					    <div>
					       <span id="message1"></span>
					       <span id="message2"></span>
					    </div>
					</div>
                    <div id="playercount" class="clickable">
                        <span class="count">0</span> <span data-i18n="ui.interface.players">players</span>
                    </div>
                    <div id="barbuttons">
                        <div id="chatbutton" class="barbutton clickable"></div>
                        <div id="achievementsbutton" class="barbutton clickable"></div>
                        <div id="helpbutton" class="barbutton clickable"></div>
                        <div id="mutebutton" class="barbutton clickable active"></div>
                    </div>
    			</div>
				<div id="chatbox">
				    <form action="none" method="get" accept-charset="utf-8">
					    <input id="chatinput" class="gp" type="text" maxlength="60">
				    </form>
				</div>
                <div id="population">
                    <div id="instance-population" class="">
                        <span>0</span> <span data-i18n="ui.interface.players_in_instance">players in your instance</span>
                    </div>
                    <div id="world-population" class="">
                        <span>0</span> <span data-i18n="ui.interface.players_total">players total</span>
                    </div>
                </div>
		    </div>
		</div>
		<footer>
		    <div id="sharing" class="clickable">
		      <span data-i18n="ui.interface.share">Share this on</span> 
              <a href="http://twitter.com/share?url=http%3A%2F%2Fbrowserquest.mozilla.org&amp;text=Mozilla%27s%20BrowserQuest%3A%20HTML5%20massively%20multiplayer%20adventure%20game%20%23demo%20%23websockets&amp;related=glecollinet:Creators%20of%20BrowserQuest%2Cwhatthefranck" class="twitter"></a>
              <a href="http://www.facebook.com/share.php?u=http://browserquest.mozilla.org/" class="facebook"></a>
		    </div>
		    <div id="credits-link" class="clickable">
		      – <span id="toggle-credits" data-i18n="ui.interface.credits">Credits</span>
		    </div>
		</footer>
		
		<ul id="page-tmpl" class="clickable" style="display:none">
        </ul>
        <ul>
            <li id="achievement-tmpl" style="display:none">
                <div class="coin"></div>
                <span class="achievement-name">???</span>
                <span class="achievement-description">???</span>
                <div class="achievement-sharing">
                  <a href="" class="twitter"></a>
                </div>
            </li>
        </ul>
        
        <img src="img/common/thingy.png" alt="" class="preload">
        
        <div id="resize-check"></div>
		
        <script type="text/javascript">
            var ctx = document.querySelector('canvas').getContext('2d'),
                parchment = document.getElementById("parchment");
            
            if(!Detect.supportsWebSocket()) {
                parchment.className = "error";
            }
            
            if(ctx.mozImageSmoothingEnabled === undefined) {
                document.querySelector('body').className += ' upscaled';
            }
            
            if(!Modernizr.localstorage) {
                var alert = document.createElement("div");
                    alert.className = 'alert';
                    alert.setAttribute('data-i18n', 'ui.notifications.cookies_required');
                    alertMsg = document.createTextNode("You need to enable cookies/localStorage to play BrowserQuest");
                    alert.appendChild(alertMsg);

                target = document.getElementById("intro");
                document.body.insertBefore(alert, target);
            } else if(localStorage && localStorage.data) {
                parchment.className = "loadcharacter";
            }
        </script>
        
        <script src="js/lib/log.js"></script>
        <script>
                var require = { waitSeconds: 60 };
        </script>
        <script data-main="js/home" src="js/lib/require-jquery.js"></script>
	</body>
</html>