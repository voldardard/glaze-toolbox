
let i=0;
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

};
function dismiss(id){
  elmnt=document.getElementById(id);
  if (elmnt) {
    elmnt.removeChild();
    elmnt.remove();
  }
};
