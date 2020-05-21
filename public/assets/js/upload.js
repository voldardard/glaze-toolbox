const url = '/tmp/upload';

function tmp_upload(id){
    const files = document.getElementById(id).files;
    formData = new FormData();

    for (let i = 0; i < files.length; i++) {
        let file = files[i];
        formData.append('pic[]', file);
    }

    fetch(url, {
        method: 'POST',
        body: formData,
    }).then(response => {
        console.log(response)
    });
}