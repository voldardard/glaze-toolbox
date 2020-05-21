var label_count=0;

function add_label(){
    label_count++;


    var container = document.getElementById("labels");

    var input = document.createElement('input');
    input.setAttribute('type', 'text');
    input.setAttribute('placeholder', 'Label');
    input.setAttribute('name', 'label['+label_count+']');
    container.appendChild(input);

    var a = document.createElement('a');
    a.classList.add("remove-label");
    a.setAttribute('onclick', 'remove_label('+label_count+')');

    var i = document.createElement('i');
    i.classList.add("fa");
    i.classList.add("fa-minus-square");
    i.setAttribute('aria-hidden', 'true');
    a.appendChild(i);

    container.appendChild(a);





}