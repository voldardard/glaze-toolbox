focusin=false;
function start_loading(icon, name="fa-check-circle"){
    console.log('start_loading');
    icon.classList.remove(name);
    icon.classList.add("fa-spinner");
}
function stop_loading(icon, name="fa-check-circle"){
    console.log('stop_loading');
    icon.classList.remove("fa-spinner");
    icon.classList.add(name);
}
function selector(element, ul){
  element.addEventListener("click", function (e) {
      console.log('click on selector');
      focusin=true;

      closeAll();
      console.log('Close All before open one');

      ul.setAttribute("style", "display: block;");
      console.log('set attribute block');
  });
  element.addEventListener("mouseout", function (e) {
      console.log('mouseout of div');
      focusin=false;
  });
  element.addEventListener("mouseover", function (e) {
      console.log('mouseover of div');
      focusin=true;
  });

};
function closeSelectorEvent(){
  console.log('Close Selector triggered');
  //closeSelectorEvent()=function(){};
  document.addEventListener("click", function (e) {
    console.log('click outside');
    if (!focusin){
        closeAll();
        console.log('closeAll')
    }

  });
};
function closeAll(){
  console.log('closeAll triggered');
  var uls = document.getElementsByClassName("selector_disabled");
  console.log('got element'+uls.length);
  for (var i = 0; i < uls.length; i++) {
      //console.log("close"+i);
      //if (elmnt != uls[i]) {
          uls[i].setAttribute("style", "display: none;");
      //}
  }
};
function update_name(id, value){
  div= document.getElementById('name-'+id);
  while(div.firstChild){
      div.removeChild(div.firstChild);
  }
  var input = document.createElement('input');
  input.setAttribute("required", "required");
  input.setAttribute("type", "text");
  input.setAttribute("placeholder", 'Category name');
  input.setAttribute("id", 'category_name_input-'+id);
  input.setAttribute("value", value);


  var i= document.createElement('i');
  i.setAttribute("class", "fa fa-floppy-o");
  i.setAttribute("aria-hidden", "true");
  i.setAttribute("onclick", "save_name("+(id)+")");


  var i2= document.createElement('i');
  i2.setAttribute("class", "fa fa-times");
  i2.setAttribute("aria-hidden", "true");
  i2.setAttribute("onclick", "cancel_name("+(id)+", '"+(value)+"')");


  div.append(input);
  div.append(i);
  div.append(i2);
};
function cancel_name(id, value){
  div= document.getElementById('name-'+id);
  while(div.firstChild){
      div.removeChild(div.firstChild);
  }


  var a = document.createElement('a');
  a.setAttribute("href", "/category/"+id);
  a.innerHTML=value;


  var i= document.createElement('i');
  i.setAttribute("class", "fa fa-pencil-square-o");
  i.setAttribute("aria-hidden", "true");
  i.setAttribute("onclick", "update_name("+(id)+", '"+(value)+"')");

  div.append(a);
  div.append(i);

}
function save_name(id){
    start_loading(this, "fa-floppy-o");
    value=document.getElementById('category_name_input-'+id).value;
    console.log(value);
    const csrf = document.getElementsByName('_csrf-token')[0].content;

    var category = {};
    category.id = id;
    category._token = csrf;
    category.name = value;

    $.ajax({
        type: "PATCH",
        url: "/category/"+id,
        dataType: 'json',
        data: category,
        success: function(msg){
            console.log(msg);
            stop_loading(this, 'fa-floppy-o');
        }
    });

}
