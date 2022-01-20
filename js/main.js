/*---- start ----*/

var xmlHttpRequest = function(){
	var xmlHttp = null;	
	try{
		xmlHttp = new XMLHttpRequest();
	}catch(e){
		try{ 
			xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		}catch(e){
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}

/*---- this Object needs to handle the JSON object returned with ajax ----*/

function handleObj(response){
	this.obj = response;
	/* this is important method for multiple objects returned with table */
	this.call_names = function(){
		for(var i in this.obj){
			this.set_obj.call(this, this.set_obj[i]);			
		}
	}
}

handleObj.prototype.set_obj = function(){
	this.name = this[name];
	for(var s in this){
		return this.name = this[s];
	}
}

function init(){
	/*---- load functions for variables enviroment ----*/
	dump.log('Avvio applicazione: init');
	loadFunctions();	
	loadAjaxFunctions();
	loadDOMFunctions();	
	dump.next('Create variabili di ambiente');
	/*---- this function process the url vars and exec the main function ----*/
	dump.next('Avvio ascoltatore indirizzo web');
	urlListener(mainFunction);	
}

function loadFunctions(){
	/* localStorage set */
	getLS = function(a){
		var c = localStorage.getItem(a);
		//alert('debug: get localstorage: ' + c);
		return c;
	}
	setLS = function(a,b){
		var c = localStorage.setItem(a,b);
		//alert('debug: set localstorage: ' + getLS(a));
		return c;
	}
	delLS = function(a){
		var c = localStorage.removeItem(a);
		alert('item cancellato');
		return c;	
	}
	clearLS = function(){
		var c = localStorage.clear();
		alert('storage cancellati con successo');
		return c;
	}
	/* parse query string */
	var a = location.search.substr(1);
	var b = a.split("&");
	if(!a) validatePage('home');
	/* app core function: get the url address and processes it */
	urlListener = function(f){
		var c = function(a,f){		
			var e = a.split("=");
			var x= e[0];
			var y = e[1];
			return f(x,y);		
		}	
		if(a && a.indexOf("&") == -1 || a.indexOf("&") !== -1){
			for(var i = 0; i < b.length; i++){	c(b[i],f); };
		}	
	}
	/* app core function: get the value url pair to do ajax call*/
	mainFunction = function(name,value){
		switch(name){
			case 'action':
				switch(value){
					default:
						setLS('page',value);
						validatePage();
						dump.next('richiamo ajaxGet');
						ajaxGet(ajax_url,'main');																
					break;
				}
			break;		
		}		
	}
	urlBuilder = function(remote,name,value,table){
		var x = remote + '?';
		x += name + '=' + value;
		if(table){
			x += '&t=' + table;
		}		
		return x;		
	}
}

function loadAjaxFunctions(){
	 var ajaX = function(method,url,div,data){
		var httpRequest = xmlHttpRequest();
		var handler = function(){
			var response = httpRequest.responseText;		
			if(httpRequest.readyState == 4){
				if(httpRequest.status == 200){
					var target = document.getElementById(div);
					try{
						getObj(response);
						dump.next('provo a eseguire metodo ajax');
					}catch(e){
						target.innerHTML = response;
					}					
				}
			}
		}
		httpRequest.onreadystatechange = handler;
		httpRequest.open(method,url, true);	
		if( method == "get" ){
			httpRequest.send(null);			
		}		
		if(method == "post"){
			httpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
			httpRequest.send(data);
		}
		dump.next('ajax successful');
	}
	ajaxGet = function(url, div) {	
		return ajaX('get', url, div);
	}
}

loadDebugFunctions = function(){
	printProp = function( obj ) {
		var str = '';
		for( var memb in obj )
			str += memb + ' = ' + obj[memb] + '\n';
		return str;
	}
}

/*
function = function(){}

/*---- edit this function to set customizable proprierties for page set up ----*/	
function validatePage(){	
	var a = getLS('page');	
	var objSettings = {
		"home" : {
			pagename: 'This is the app generated title Home Page',			
			table: null
		} ,
		"test_string" : {
			pagename: 'Test String',						
			table: null
		} ,
		"do_table" : {
			pagename: 'This table is dom generate by Json Object returned from ajax.',	
			_function: mainTable,		
			table: 'demo_table'
		},
		"do_select" : {
			pagename: 'This is the attempt to build a select from app.',	
			_function: buildSelect,		
			table: 'demo_table'
		}
	};
	dump.next('richiamo locals storage ed eseguo settaggio propriet� validatePage');
	var page_item = objSettings[a];
	build_ajax_callb = page_item._function;
	msg = page_item.pagename;
	ajax_url = urlBuilder('php/response.php','action',a, page_item.table);		
}

/* handle json object ajax response and does callback */
function getObj(response){		
	var _object = eval("("+response+")");
	if(typeof (_object) == 'object'){
		build_ajax_callb(_object,'main','my_div');		
	} else return false;
}


var doMsg = function(msg, id) {
	var target = document.getElementById(id);
	target.innerHTML = msg;
	return target;
}

/*
doSelect('main','myselect');
option('1','prova');
option('2','prova1');
*/
window.dump = {
	// Variabile conteggio
	i: 0,
	// Console
	log: function(m){
		console.log(m);
	},
	// Fai un passo
	next: function(msg){
		dump.i++;
		console.log("dump " + dump.i  + ': ' + msg);
	},
	// Resetta il conteggio
	reset: function(){
		dump.i = 0;
	}
}
/* usage
dump.log(something);
dump.next();
dump.next();
*/

function inspect(obj){
	dump.reset();
	dump.log('Debug object');
	dump.next('Object possesses these properties:');
	var message = '';
	for (var i in obj){
		message += i + ': ' + obj[i];
		dump.next(message);
	}		
}

