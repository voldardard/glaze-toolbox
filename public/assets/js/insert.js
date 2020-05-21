var label_count=0;

function add_label(){
    label_count++;


    var container = document.getElementById("labels");
    var input = document.createElement('input');
    input.setAttribute('type', 'text');
    input.setAttribute('placeholder', 'Label');
    input.setAttribute('name', 'label['+label_count+']');

    container.appendChild(input);

    document.getElementById("labels").value=label_count;

}