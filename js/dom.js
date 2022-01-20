/* DOM */


function loadDOMFunctions(){
	var e = function(type,target){	
		this.el = document.createElement(type);	 
		document.getElementById(target).appendChild(this.el);	
	}
	e.prototype.inner = function(text){
		return this.el.innerHTML = text;
	}
	e.prototype.set_a = function(a,b){	
		return this.el.setAttribute(a,b);
	}
	mainTable = function(object,target,id){
		doMsg(msg,'main');
		var initObj = new handleObj(object);		
		var div = document.getElementById(target);
		var t = document.createElement('table');
		t.setAttribute('id',id);		
		/* thhead */
		var th = document.createElement('thead');
		var rh = document.createElement('tr');
		/* tfoot */
		var tf = document.createElement('tfoot');	
		var rf = document.createElement('tr');		
		for (var x in initObj.obj[0]){	
			/* thhead */		
			var dh = document.createElement('th');			
			var dht = document.createTextNode(x);
			dh.appendChild(dht);
			rh.appendChild(dh);
			/* tfoot */
			var df = document.createElement('td');
			var dft = document.createTextNode('table footer');
			df.appendChild(dft);
			rf.appendChild(df);
		}
		/* thhead */
		th.appendChild(rh);
		t.appendChild(th);			
		/* tfoot */
		tf.appendChild(rf);
		t.appendChild(tf);
		/* tbody */
		var tb = document.createElement('tbody');
		for (var i in initObj.obj){
			var r = document.createElement('tr');
			initObj.call_names();			
			for (var y in initObj.obj[i]){
				var d = document.createElement('td');
				var a_ = document.createElement('A');
				var obj_text = document.createTextNode(initObj.obj[i][y]);
				a_.appendChild(obj_text);				
				d.appendChild(a_);		
				r.appendChild(d);
				//a_.href = doLink('index.php','f_edit',i,this);
				/* a_.href = 'index.html?action=edit&thbs=' + get('tabs') + '&id=' + this.obj[i]['id'];	*/		
			}
			tb.appendChild(r);
		}
		/* chiude tabella */
		t.appendChild(tb);
		/* appende child nel div */
		div.appendChild(t);		
	}
	buildSelect = function(object,target,id){
		doMsg(msg,'main');
		var div = document.getElementById(target);
		var s = document.createElement('select');
		s.setAttribute('id',id);
		div.appendChild(s);
		option = function(value,txt){
			var my_option = document.createElement('option');
			my_option.value = value;
			my_option.text = txt;		
			//var sel = document.getElementById(id);
			s.add(my_option, null);		
		}
		var a = new handleObj(object);
		for (var i in a.obj){			
			a.call_names();						
			for (var y in a.obj[i]){
				option(a.obj[i]['email'],a.obj[i]['email']);				
			}
		}		
		/*
		dump.log(initObj.call_names);
		initObj.call_names();
		var list = initObj.obj;		
		for (var x in list){
			option(list[x],list[x]);
		}
		*/
		
	}	
}

/*
function cSelect(response){
	var obj = new myObj(response);	
	var list_obj = obj.respObj;
	do_select(list_obj,'select_1','s_tbl','tabs');	
}

for (var i in obj){
		var my_option = document.createElement('OPTION');		
		my_option.value = obj[i];
		my_option_text = document.createTextNode(my_option.value);
		my_option.appendChild(my_option_text);
		sel.add(my_option, null);		
	}

function myObj(object){	
	this.respObj = object;
	this.callProperty = function(){
		for(var i in this.respObj){
			this.propertyObj.call(this, this.respObj[i]);			
		}
	}
	this.propertyObj = function(){
		this.name = this[name];
		for(var s in this.respObj){
			this.name = this.respObj[s];
		}
	}	
}
*/

