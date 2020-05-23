var label_count=0;
const url = '/upload';


function add_label(){
    label_count++;


    var container = document.getElementById("labels");

    var input = document.createElement('input');
    input.setAttribute('type', 'text');
    input.setAttribute('placeholder', 'Label');
    input.setAttribute('name', 'label[]');
    input.id= 'label-'+(label_count);
    container.appendChild(input);

    var a = document.createElement('a');
    a.classList.add("remove-label");
    a.setAttribute('onclick', 'remove_label('+label_count+')');
    a.id= 'label-remove-'+(label_count);

    var i = document.createElement('i');
    i.classList.add("fa");
    i.classList.add("fa-minus-square");
    i.setAttribute('aria-hidden', 'true');
    a.appendChild(i);

    container.appendChild(a);

}
function remove_label(label_id){
    console.log("remove: "+label_id)
    document.getElementById( 'label-'+(label_id)).remove();
    document.getElementById( 'label-remove-'+(label_id)).remove();
}
function alert_warning(message){
    var container = document.getElementById("alert");


    var div = document.createElement('div');
    div.classList.add("alert");
    div.classList.add("alert-danger");
    div.classList.add("alert-dismissible");
    div.classList.add("fade");
    div.classList.add("show");
    div.classList.add("fixed-top");
    div.innerHTML=message;

    var button = document.createElement('button');
    button.setAttribute('type', 'button');
    button.classList.add("close");
    button.setAttribute('data-dismiss', 'alert');
    button.innerHTML='x';
    div.appendChild(button);

    container.appendChild(div);

}
function start_loading(iconId){
    const icon = document.getElementById(iconId);
    icon.classList.remove("fa-upload");
    icon.classList.add("fa-spinner");


}
function stop_loading(iconId){
    const icon = document.getElementById(iconId);
    icon.classList.remove("fa-spinner");
    icon.classList.add("fa-upload");
}
function create_miniature(id, url){
    container = document.getElementById(id);
    container.appendChild(div);

    var img = document.createElement('img');
    img.setAttribute('src', url);
    div.append(img);

    var input = document.createElement('input');
    input.setAttribute('type', 'text');
    input.setAttribute('placeholder', 'Nom de l\'image');
    input.setAttribute('name', 'pictures');

    div.appendChild(input);
}
function tmp_upload(id, iconId){
    let json_answer;
    start_loading(iconId);
    files = document.getElementById(id).files;
    const csrf = document.getElementsByName('_csrf-token')[0].content;
    console.log(csrf);
    formData = new FormData();
    const headers = new Headers({
        'X-CSRF-TOKEN': csrf
    });


    for (let i = 0; i < files.length; i++) {
        let file = files[i];
        formData.append('pic[]', file);
    }

    fetch(url, {
        method: 'POST',
        headers,
        body: formData,
    }).then(function(response) {
        if (!response.ok) {
            throw Error(response.statusText);
        }else{
            return response.json();
        }
    }).then(data => {
        // Work with JSON data here
        console.log(data);
        json_answer=data;
        document.getElementById(id).value="";
        stop_loading(iconId);
        //var json = JSON.parse(data);// here data is your response
        for (var key in data) {
            create_miniature(id, url);
        }
    }).catch(function(error) {
            console.log('Il y a eu un problème avec l\'opération fetch: ' + error.message);
            alert_warning('There was a problem with connection : '+error.message);
            stop_loading(iconId);
    });






}