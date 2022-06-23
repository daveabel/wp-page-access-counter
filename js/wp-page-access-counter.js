window.addEventListener('load', function () {

    var element = document.getElementById('clear_cookie'); // grab a reference to your element
    element.addEventListener('click', clickHandler); 
    
    });
    
    /**
     * @name clickHandler
     * @description Function that clears counter cookie (and asks for confirmation before)
     * @param {Event} e 
     * 
     */
    function clickHandler(e){ // declare a function that updates the state
         let name = my_script_vars.region; 
          e.preventDefault();
            if (confirm("Willst du das Spiel wirklich neu starten? Alle gescannten QR-Codes müssen neu gescannt werden!")) {
                eraseCookie(name)
                location.reload()
    }
    }
    
    /**
     * @description Adds an Event Listener when page is loaded. 
     *              Adds the current post_id to cookie and calls show_secret()
     * 
     */
    window.addEventListener('load', function () {
       
        let name = my_script_vars.region;  
        let secret = my_script_vars.secret;
        let modulo = my_script_vars.modulo;
        let showwholesecret = my_script_vars.showwholesecret;
        let complete_steps = secret.length * modulo
        if (name){
        let days = 1;
        let post_id = my_script_vars.postID;
        let post_ids = JSON.parse(readCookie(name));
        if( post_ids ) {
            if (post_ids.includes(post_id)){
                //pass
            }
            else {
                post_ids.push(post_id)
            }
        } else {
        post_ids = [post_id]; 
        }
    
        createCookie(name, JSON.stringify(post_ids), days)
        //console.log('länge des Arrays:' + post_ids.length)
        show_secret(post_ids.length, modulo,secret, complete_steps, showwholesecret);
        
        if(post_ids.length % modulo == 0 || (post_ids.length * modulo) >= complete_steps )
        {      
           // eraseCookie(name)
        }   
        }
    });
    
    /**
     * @name show_secret
     * @description Function that shows a part of the secret word in dependency of the number of page-accesses needed
     * @param {Number} length number of actual page accesses
     * @param {Number} modulo number of page accesses needed to show a part of the secret
     * @param {string} secret the secret word
     * @param {Number} complete_steps number of letters in secret word multiplied
     * @param {Number} showwholesecret true/false if the whole secret should be shown or just one letter after another
     * 
     */
    function show_secret(length, modulo, secret,complete_steps, showwholesecret){
        let counter = length / modulo;
        //console.log('Counter: ' + Math.floor(counter));
        let result = secret.slice(0, Math.floor(counter));
        let elem = document.getElementById("secret");

    
        if(length >= modulo && showwholesecret == 1)
        {
            let secret_str = document.createTextNode (secret);
            elem.appendChild(secret_str);
        }
        else
        {
            let secret_str = document.createTextNode (result);
            elem.appendChild(secret_str);
        }
            
        
        
        if(length >= complete_steps) 
        {
            let result_wrapper = document.getElementById("result");
            let node = document.createTextNode ('Super, du hast alle Buchstaben des Lösungswortes gefunden!');
            result_wrapper.appendChild(node);
        }
    
    }
    
    /**
     * @name createCookie
     * @description Function that creates a cookie and sets value and expiration-date
     * @param {String} name the name of the cookie
     * @param {Number} value value of cookie
     * @param {Number} days number of days the cookie should be valid
     * 
     */
    function createCookie(name, value, days) {
        var expires;
    
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        } else {
            expires = "";
        }
        document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
    }
    
    /**
     * @name readCookie
     * @description Function that reads the value of a given cookie and returns a specific amount of letters of the
     *              secret word depending on the actual page-accesses
     * @param {String} name the name of the cookie
     * 
     * @returns {string} letters of the secret word depending the actual page-accesses 
     */
    function readCookie(name) {
        var nameEQ = encodeURIComponent(name) + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) === ' ')
                c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0)
                return decodeURIComponent(c.substring(nameEQ.length, c.length));
        }
        return null;
    }
    
    /**
     * @name eraseCookie
     * @description Function that erases a given cookie
     * @param {String} name the name of the cookie
     * 
     */
    function eraseCookie(name) {
        createCookie(name, "", -1);
    }
    
    