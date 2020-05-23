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
function tmp_upload(id){
    const files = document.getElementById(id).files;
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
    }).then(response => {
            if(response.ok) {
                response.json()
            }else{

            }
        })

}