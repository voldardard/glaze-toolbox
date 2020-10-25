
let i=0;
const AUTOMATIC_DISMISS_IN_SECOND=5;

function alert_warning(message, automatic_dismiss=true){

    var container = document.getElementById("alert");
    var id="alert-"+i;
    console.log('set id:'+id);


    var div = document.createElement('div');
    div.classList.add("alert");
    div.classList.add("alert-danger");
    div.classList.add("alert-dismissible");
    div.classList.add("fade");
    div.classList.add("show");
    div.classList.add("fixed-top");
    div.setAttribute('id', id);

    div.innerHTML=message;

    var button = document.createElement('button');
    button.setAttribute('type', 'button');
    button.classList.add("close");
    button.setAttribute('data-dismiss', 'alert');
    button.innerHTML='x';
    button.setAttribute("onclick", "dismiss('"+id+"')");

    div.appendChild(button);

    container.appendChild(div);
    if(automatic_dismiss){
      setTimeout(function(){
        dismiss(id);
      }, (AUTOMATIC_DISMISS_IN_SECOND*1000));
    }
    i++;

};
function alert_success(message, automatic_dismiss=true){
    var container = document.getElementById("alert");
    var id="alert-"+i;
    console.log('set id:'+id);


    var div = document.createElement('div');
    div.classList.add("alert");
    div.classList.add("alert-success");
    div.classList.add("alert-dismissible");
    div.classList.add("fade");
    div.classList.add("show");
    div.classList.add("fixed-top");
    div.setAttribute('id', id);

    div.innerHTML=message;

    var button = document.createElement('button');
    button.setAttribute('type', 'button');
    button.classList.add("close");
    button.setAttribute('data-dismiss', 'alert');
    button.innerHTML='x';
    button.setAttribute("onclick", "dismiss('"+id+"')");

    div.appendChild(button);

    container.appendChild(div);

    if(automatic_dismiss){
      setTimeout(function(){
        dismiss(id);
      }, (AUTOMATIC_DISMISS_IN_SECOND*1000));
    }
    
    i++;

};
function dismiss(id){
  console.log('dissmis'+id);
  var elmnt=document.getElementById(id);
  if (elmnt) {
    while(elmnt.firstChild){
        elmnt.removeChild(elmnt.firstChild);
    }
    elmnt.remove();
  }
};
