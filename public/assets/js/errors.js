
let i=0;
const AUTOMATIC_DISMISS_IN_SECOND=5;

function alert_warning(message){
    var container = document.getElementById("alert");


    var div = document.createElement('div');
    div.classList.add("alert");
    div.classList.add("alert-danger");
    div.classList.add("alert-dismissible");
    div.classList.add("fade");
    div.classList.add("show");
    div.classList.add("fixed-top");
    div.setAttribute('id', 'alert-'+i);

    div.innerHTML=message;

    var button = document.createElement('button');
    button.setAttribute('type', 'button');
    button.classList.add("close");
    button.setAttribute('data-dismiss', 'alert');
    button.innerHTML='x';
    button.setAttribute("onclick", "dismiss('alert-"+(i)+"')");

    div.appendChild(button);

    container.appendChild(div);

    i++;
    setTimeout(function(){
      dismiss('alert-'+i);
    }, (AUTOMATIC_DISMISS_IN_SECOND*1000));


};
function alert_success(message){
    var container = document.getElementById("alert");


    var div = document.createElement('div');
    div.classList.add("alert");
    div.classList.add("alert-success");
    div.classList.add("alert-dismissible");
    div.classList.add("fade");
    div.classList.add("show");
    div.classList.add("fixed-top");
    div.setAttribute('id', 'alert-'+i);

    div.innerHTML=message;

    var button = document.createElement('button');
    button.setAttribute('type', 'button');
    button.classList.add("close");
    button.setAttribute('data-dismiss', 'alert');
    button.innerHTML='x';
    button.setAttribute("onclick", "dismiss('alert-"+(i)+"')");

    div.appendChild(button);

    container.appendChild(div);

    i++;
    setTimeout(function(){
      dismiss('alert-'+i);
    }, (AUTOMATIC_DISMISS_IN_SECOND*1000));

};
function dismiss(id){
  console.log('dissmis'+id);
  elmnt=document.getElementById(id);
  if (elmnt) {
    while(elmnt.firstChild){
        elmnt.removeChild(elmnt.firstChild);
    }
    elmnt.remove();
  }
};
