function add_label(){

    var count = document.getElementById("labels").value;

    var container = document.getElementById("labels");
    var input = document.createElement('input');
    input.setAttribute('type', 'text');
    input.setAttribute('placeholder', 'Label');
    input.setAttribute('name', 'label['+(Number(count)+1)+']');

    container.appendChild(input);

    document.getElementById("labels").value=(Number(count)+1);

}