// JavaScript Document
	var tab = new function(){
			function ul(id){
					return document.getElementById(id);
				}
				this.card = function(num){
						var li_obj = ul(num).getElementsByTagName("li");
						var sum = li_obj.length;
						for(var i = 0;i<sum;i++){
								li_obj[i].onmouseover = (function(i){
												return function(){
														for(var c = 0;c<sum;c++){
																li_obj[c].className = "";
																document.getElementById(num+c).style.display = "none";
															}
															li_obj[i].className = "focus";
															document.getElementById(num+i).style.display = "block";
													}						  
										}(i));
							}
					}
		}
		tab.card("card0");
