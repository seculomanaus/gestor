var ore = 0, minuti = 0, secondi = 0, decimi = 0;
var vis = "";
var stop = true;

function avvia() {
	if(stop == true) {
		stop = false;
		cronometro();
	}
}

function cronometro() {
	if(stop == false) {
		decimi++;
		if(decimi > 9) {
			decimi = 0;
			secondi++;
		}
		if(secondi > 59) {
			secondi = 0;
			minuti++;
		}
		if(minuti > 59) {
			minuti = 0;
			ore++;
		}
		mostra();
		setTimeout("cronometro()", 100);
	}
}
function mostra() {
    if(ore < 10) vis = "0"; else vis = ore;
    if(minuti < 10) vis = vis + "0";
    vis = vis + minuti + ":";
    if(secondi < 10) vis = vis + "0";
    vis = vis + secondi + ":" + decimi;
    document.getElementById("vis").innerHTML = vis;
}

function backtime() {
    //000:02:1 21s  00:00:21
    if(ore < 10) vis = "0"+ore+":"; else vis = ore+":";
    if(minuti < 10) vis += "0";
    vis = vis + minuti + ":"; //000:
    if(secondi < 10) vis = vis + "0";
    vis = vis + secondi; // + ":" + decimi;
    return(vis);
}

function ferma() {
	stop = true;
}
function azzera() {
    if(stop == false) {
        stop = true;
    }
    ore = minuti = secondi = decimi = 0;
    vis = "";
    mostra();
}


$(window).on('load', function() {
    
    
    function checkKey(e) {
        e = e || event;
        var code = e.which || e.keyCode || e.charCode;
        var cando = !([8, 46].indexOf(code) > -1);
        void (!cando && Helpers.log2Screen('`&lt;',code == 8 && 'Backspace' || 'Delete', '&gt`', ' is disabled',{
            clear: true
            })
        );
        return cando;
    }

    
    
    function disableF5(e){

        if ((e.which || e.keyCode) === 116) e.preventDefault(); // F5
       
        if ((e.which || e.keyCode) === 112) e.preventDefault(); // F1
        if ((e.which || e.keyCode) === 114) e.preventDefault(); // F3
        if ((e.which || e.keyCode) === 113) e.preventDefault(); // F2
        if ((e.which || e.keyCode) === 117) e.preventDefault(); // F6
        if ((e.which || e.keyCode) === 17) e.preventDefault(); // CONTROL
        if ((e.which || e.keyCode) === 27) e.preventDefault(); //alert("oi");// ESC
        if ((e.which || e.keyCode) === 121) e.preventDefault(); // F10
        if ((e.which || e.keyCode) === 122) e.preventDefault(); // F11
        if ((e.which || e.keyCode) === 123) e.preventDefault(); // F12
        
        if ((e.which || e.keyCode) === 12) e.preventDefault(); // ALT
        if ((e.which || e.keyCode) === 18) e.preventDefault(); // ALT
        if ((e.which || e.keyCode )=== 9) e.preventDefault();  // TAB
        if ((e.which || e.keyCode) === 84) e.preventDefault(); // T
        if ((e.which || e.keyCode) === 78) e.preventDefault(); // N
        if ((e.which || e.keyCode) === 82) e.preventDefault(); // R
        if ((e.which || e.keyCode) === 8) e.preventDefault();  // BACKSPACE
      
        //{event.keyCode=0; event.returnValue=false;}
        
        /*if (((e.which || e.keyCode) === 84) ||((e.which || e.keyCode) === 17)||((e.which || e.keyCode) === 116)||((e.which || e.keyCode)=== 9)||((e.which || e.keyCode) === 12)||((e.which || e.keyCode) === 18)){
            
            alert("Função não permitida: "+e.keyCode);
            
            e.preventDefault();
        return false;
        }*/   
        
        
      
    }
    
    $(document).on("keydown", disableF5);
    
    $(document).on("keyup", disableF5);
     
    $(document).on("keypress", disableF5);
    
    
});


// Bloqueia setas do navegador
(function(window) { 
  'use strict'; 
 
var noback = { 
     
    //globals 
    version: '0.0.1', 
    history_api : typeof history.pushState !== 'undefined', 
     
    init:function(){ 
        window.location.hash = '#no-back'; 
        noback.configure(); 
    }, 
     
    hasChanged:function(){ 
        if (window.location.hash == '#no-back' ){ 
            window.location.hash = '#BLOQUEIO';
            //mostra mensagem que não pode usar o btn volta do browser
            if($( "#msgAviso" ).css('display') =='none'){
                $( "#msgAviso" ).slideToggle("slow");
            }
        } 
    }, 
     
    checkCompat: function(){ 
        if(window.addEventListener) { 
            window.addEventListener("hashchange", noback.hasChanged, false); 
        }else if (window.attachEvent) { 
            window.attachEvent("onhashchange", noback.hasChanged); 
        }else{ 
            window.onhashchange = noback.hasChanged; 
        } 
    }, 
     
    configure: function(){ 
        if ( window.location.hash == '#no-back' ) { 
            if ( this.history_api ){ 
                history.pushState(null, '', '#BLOQUEIO'); 
            }else{  
                window.location.hash = '#BLOQUEIO';
                //mostra mensagem que não pode usar o btn volta do browser
                if($( "#msgAviso" ).css('display') =='none'){
                    $( "#msgAviso" ).slideToggle("slow");
                }
            } 
        } 
        noback.checkCompat(); 
        noback.hasChanged(); 
    } 
     
    }; 
     
    // AMD support 
    if (typeof define === 'function' && define.amd) { 
        define( function() { return noback; } ); 
    }  
    // For CommonJS and CommonJS-like 
    else if (typeof module === 'object' && module.exports) { 
        module.exports = noback; 
    }  
    else { 
        window.noback = noback; 
    } 
    noback.init();
}(window)); 

