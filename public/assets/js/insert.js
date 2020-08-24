var label_count=0;
var miniature_count=0;
const url = '/upload';

//Utils
function fetchJson(method, url, callback){
    console.log(url);
    const headers = new Headers({
        'accept': 'application/json'
    });

    fetch(url, {
        method: method,
        headers,
    }).then(function(response) {
        if (!response.ok) {
            throw Error('error:'+response.statusText+' statuscode:'+response.status);

        }else{
            return response.json();
        }
    }).then(data => {
        callback(data);
    });
}

//-------------
function translate(key) {
    if (key in lang) {
        return lang[key];
    } else {
        return key;
    }
}

class autocomplete_author_callback {
    constructor(level, url) {
        this.level = level;
        this.url = url;
    }

    click = function (parentID) {
        //remove event listener
        /*       var inp = document.getElementById('sources-author-' + this.level);
               inp.removeEventListener('focusin', null);
               inp.removeEventListener('input', null);
               inp.removeEventListener('focusout', null);
               inp.removeEventListener('keydown', null);*/
        var el = document.getElementById('sources-author-' + this.level),
            elClone = el.cloneNode(true);
        el.parentNode.replaceChild(elClone, el);

        console.log('removed event listener');
        const level = this.level;

        fetchJson('GET', this.url + parentID, function (data) {
            console.log('fetched:');
            console.log(data);

            if (data.length !== 0) {
                console.log(data);
                autocomplete(document.getElementById("sources-author-" + level), data);
            } else {
                console.log('no data, no autocompletion');
            }
        });

    }
}

class autocomplete_categories_callback {
    constructor(level, url) {
        this.level = level;
        this.url = url;
    }

    click = function (parentID) {
        const level = this.level;
        const url = this.url;

        remove_category((level + 1));

        fetchJson('GET', this.url + parentID, function (data) {
            console.log('fetched:');
            console.log(data);
            if (data.length !== 0) {
                add_category((level + 1));
                console.log(data);
                autocomplete_complex(document.getElementById("add-categories-" + (level + 1)), data, new autocomplete_categories_callback((level + 1), url));
//                autocomplete_category(document.getElementById("add-categories-" + (level + 1)), data, (level + 1));
            }
        });

    }
}

function add_category(level) {
    var div = document.getElementById('categories');
    var subdiv = document.createElement('div');
    subdiv.setAttribute("class", "autocomplete");
    subdiv.setAttribute("level", (level));
    subdiv.setAttribute("id", 'level-' + (level));
    subdiv.setAttribute("style", "width: " + (100 - level) + "%; float: right;")


    var input = document.createElement('input');
    input.setAttribute("required", "required");
    input.setAttribute("type", "text");
    input.setAttribute("placeholder", translate('subCategory'));
    input.setAttribute("name", 'category['+level+']');

    input.setAttribute("id", "add-categories-" + level);

    var i= document.createElement('i');
    i.setAttribute("class", "fa fa-minus-square");
    i.setAttribute("aria-hidden", "true");
    var a= document.createElement('a');
    a.setAttribute("id", "categories-remove-" + (level));
    a.setAttribute("class", "remove-categories");
    a.setAttribute("onclick", "remove_category("+(level)+")");
    a.appendChild(i);


    subdiv.appendChild(input);
    subdiv.appendChild(a);

    div.appendChild(subdiv);

    //update create button
    var button = document.getElementById('add_category');
    button.setAttribute("onclick", "add_category("+(level+1)+")");
}
function remove_category(level){

    for(var i=(level);  i<(level+25); i++){
        console.log('trying to find:'+i);
        var levelBelow = document.getElementById( 'level-'+i);
        if(levelBelow){
            console.log('Remove: level-' + i);
            levelBelow.remove();
        }
    }


    //update create button
    var button = document.getElementById('add_category');
    button.setAttribute("onclick", "add_category(" + (level) + ")");
}

function add_raw(level) {
    var div = document.getElementById('raw-container');
    var subdiv = document.createElement('div');
    subdiv.setAttribute("id", 'raw-' + (level));
    subdiv.setAttribute("class", 'raw-subdiv');

    var subsubdiv = document.createElement('div');
    subsubdiv.setAttribute("class", 'autocomplete');

    var input = document.createElement('input');
    input.setAttribute("required", "required");
    input.setAttribute("type", "text");
    input.setAttribute("placeholder", translate('rawMaterials'));
    input.setAttribute("name", 'raw[' + level + '][name]');
    input.setAttribute("id", "raw-name-" + level);

    var input2 = document.createElement('input');
    input2.setAttribute("type", "text");
    input2.setAttribute("placeholder", translate('formula'));
    input2.setAttribute("name", 'raw[' + level + '][formula]');
    input2.setAttribute("id", "raw-formula-" + level);

    var input3 = document.createElement('input');
    input.setAttribute("required", "required");
    input3.setAttribute("type", "number");
    input3.setAttribute("placeholder", translate('quantity'));
    input3.setAttribute("name", 'raw[' + level + '][quantity]');
    input3.setAttribute("id", "raw-quantity-" + level);
    input3.setAttribute('class', 'quantity-to-sum')

    var i = document.createElement('i');
    i.setAttribute("class", "fa fa-minus-square");
    i.setAttribute("aria-hidden", "true");
    var a = document.createElement('a');
    a.setAttribute("id", "raw-remove-" + (level));
    a.setAttribute("class", "remove-raw");
    a.setAttribute("onclick", "remove_raw(" + (level) + ")");
    a.appendChild(i);


    subsubdiv.appendChild(input);
    subdiv.appendChild(subsubdiv);
    subdiv.appendChild(input2);
    subdiv.appendChild(input3);
    subdiv.appendChild(a);

    div.appendChild(subdiv);


    //enable autocomplete
    autocomplete_raw(document.getElementById("raw-name-" + level), raw, level);

    //enable count verification to enable button
    listen_input(document.getElementById('raw-quantity-' + level));


    //update create button
    var button = document.getElementById('add_raw');
    button.setAttribute("onclick", "add_raw(" + (level + 1) + ")");


}

function remove_raw(level) {
    var raw = document.getElementById('raw-' + level);
    if (raw) {
        console.log('Remove: raw-' + level);
        raw.remove();
    }


    //update create button
    //do not decrease or risk to have same id 2 time
    // var button = document.getElementById('add_raw');
    // button.setAttribute("onclick", "add_raw(" + (level) + ")");
}

function add_raw_extra(level) {
    var div = document.getElementById('raw-extra-container');
    var subdiv = document.createElement('div');
    subdiv.setAttribute("id", 'raw-extra-' + (level));
    subdiv.setAttribute("class", 'raw-extra-subdiv');

    var subsubdiv = document.createElement('div');
    subsubdiv.setAttribute("class", 'autocomplete');

    var input = document.createElement('input');
    input.setAttribute("required", "required");
    input.setAttribute("type", "text");
    input.setAttribute("placeholder", translate('rawMaterials'));
    input.setAttribute("name", 'raw-extra[' + level + '][name]');
    input.setAttribute("id", "raw-extra-name-" + level);

    var input2 = document.createElement('input');
    input2.setAttribute("type", "text");
    input2.setAttribute("placeholder", translate('formula'));
    input2.setAttribute("name", 'raw-extra[' + level + '][formula]');
    input2.setAttribute("id", "raw-extra-formula-" + level);

    var input3 = document.createElement('input');
    input.setAttribute("required", "required");
    input3.setAttribute("type", "number");
    input3.setAttribute("placeholder", translate('quantity'));
    input3.setAttribute("name", 'raw-extra[' + level + '][quantity]');
    input3.setAttribute("id", "raw-extra-quantity-" + level);

    var i = document.createElement('i');
    i.setAttribute("class", "fa fa-minus-square");
    i.setAttribute("aria-hidden", "true");
    var a = document.createElement('a');
    a.setAttribute("id", "raw-extra-remove-" + (level));
    a.setAttribute("class", "remove-raw-extra");
    a.setAttribute("onclick", "remove_raw_extra(" + (level) + ")");
    a.appendChild(i);


    subsubdiv.appendChild(input);
    subdiv.appendChild(subsubdiv);
    subdiv.appendChild(input2);
    subdiv.appendChild(input3);
    subdiv.appendChild(a);

    div.appendChild(subdiv);


    //enable autocomplete
    autocomplete_raw(document.getElementById("raw-extra-name-" + level), raw, level, true);

    //update create button
    var button = document.getElementById('add_raw_extra');
    button.setAttribute("onclick", "add_raw_extra(" + (level + 1) + ")");


}

function remove_raw_extra(level) {
    var raw = document.getElementById('raw-extra-' + level);
    if (raw) {
        console.log('Remove: raw-extra-' + level);
        raw.remove();
    }

}
function add_sources(level) {
    var div = document.getElementById('sources-container');
    var subdiv = document.createElement('div');
    subdiv.setAttribute("id", 'sources-' + (level));
    subdiv.setAttribute("class", 'boxed');

    var i = document.createElement('i');
    i.setAttribute("class", "fa fa-minus-square");
    i.setAttribute("aria-hidden", "true");
    var a = document.createElement('a');
    a.setAttribute("id", "sources-remove-" + (level));
    a.setAttribute("class", "remove-sources");
    a.setAttribute("onclick", "remove_sources(" + (level) + ")");
    a.appendChild(i);

    var line = document.createElement('div');
    line.setAttribute("class", 'line');

    var element1 = document.createElement('div');
    element1.setAttribute("class", 'block');
    var input = document.createElement('input');
    input.setAttribute("required", "required");
    input.setAttribute("type", "text");
    input.setAttribute("placeholder", translate('name'));
    input.setAttribute("name", 'sources[' + level + '][name]');
    input.setAttribute("id", "sources-name-" + level);

    var element2 = document.createElement('div');
    element2.setAttribute("class", 'block');
    var input2 = document.createElement('input');
    input2.setAttribute("required", "required");
    input2.setAttribute("type", "number");
    input2.setAttribute("placeholder", translate('year'));
    input2.setAttribute("name", 'sources[' + level + '][year]');
    input2.setAttribute("id", "sources-year-" + level);
    input2.setAttribute("min", '1700');
    input2.setAttribute("max", '2100');
    element1.appendChild(input);
    element2.appendChild(input2);
    line.appendChild(element1);
    line.append(" ");
    line.appendChild(element2);


    var line2 = document.createElement('div');
    line2.setAttribute("class", 'line');
    var element3 = document.createElement('div');
    element3.setAttribute("class", 'autocomplete block');
    var input3 = document.createElement('input');
    input3.setAttribute("required", "required");
    input3.setAttribute("type", "text");
    input3.setAttribute("placeholder", translate('sources_type'));
    input3.setAttribute("name", 'sources[' + level + '][type]');
    input3.setAttribute("id", "sources-type-" + level);
    var element4 = document.createElement('div');
    element4.setAttribute("class", 'autocomplete block');
    var input4 = document.createElement('input');
    input4.setAttribute("required", "required");
    input4.setAttribute("type", "text");
    input4.setAttribute("placeholder", translate('author'));
    input4.setAttribute("name", 'sources[' + level + '][author]');
    input4.setAttribute("id", "sources-author-" + level);
    element3.appendChild(input3);
    element4.appendChild(input4);
    line2.appendChild(element3);
    line2.append(" ");
    line2.appendChild(element4);

    var line3 = document.createElement('div');
    line3.setAttribute("class", 'line');
    var textarea = document.createElement('textarea');
    textarea.setAttribute("required", "required");
    textarea.setAttribute("type", "number");
    textarea.setAttribute("placeholder", translate('description'));
    textarea.setAttribute("name", 'sources[' + level + '][description]');
    textarea.setAttribute("id", "sources-description-" + level);
    line3.appendChild(textarea);

    subdiv.appendChild(a);
    subdiv.appendChild(line);
    subdiv.appendChild(line2);
    subdiv.appendChild(line3);

    div.appendChild(subdiv);


    //enable autocomplete
    autocomplete(document.getElementById("sources-author-" + level), authors);
    //autocomplete(document.getElementById("sources-type-" + level), types);
    autocomplete_complex(document.getElementById("sources-type-" + level), types, new autocomplete_author_callback(level, '/' + locale + '/autocomplete/sources/author/type/'));


    //update create button
    var button = document.getElementById('add_sources');
    button.setAttribute("onclick", "add_sources(" + (level + 1) + ")");


}

function remove_sources(level) {
    var raw = document.getElementById('sources-' + level);
    if (raw) {
        console.log('Remove: sources-' + level);
        raw.remove();
    }
}

function add_label() {

    var container = document.getElementById("labels");

    var div = document.createElement('div');
    div.setAttribute('class', 'autocomplete');
    div.id = 'label-container-' + (label_count);


    var input = document.createElement('input');
    input.setAttribute('type', 'text');
    input.setAttribute('placeholder', translate('label'));
    input.setAttribute('name', 'label[]');
    input.id = 'label-' + (label_count);
    div.appendChild(input);

    var a = document.createElement('a');
    a.classList.add("remove-label");
    a.setAttribute('onclick', 'remove_label(' + label_count + ')');
    a.id = 'label-remove-' + (label_count);

    var i = document.createElement('i');
    i.classList.add("fa");
    i.classList.add("fa-minus-square");
    i.setAttribute('aria-hidden', 'true');
    a.appendChild(i);

    div.appendChild(a);
    container.appendChild(div);

    autocomplete(document.getElementById("label-" + (label_count)), labels);

    label_count++;

}
function remove_label(label_id){
   /* console.log("remove: "+label_id)*/
    document.getElementById('label-container-' + (label_id)).remove();
}
function miniature_remove(miniature_id){
  /*  console.log("remove: "+miniature_id)*/
    document.getElementById( 'miniature-'+(miniature_id)).remove();
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
function start_loading(iconId) {
    const icon = document.getElementById(iconId);
    icon.classList.remove("fa-upload");
    icon.classList.add("fa-spinner");


}

function stop_loading(iconId) {
    const icon = document.getElementById(iconId);
    icon.classList.remove("fa-spinner");
    icon.classList.add("fa-upload");
}

function create_miniature(id, picture) {
    miniature_count++;
    container = document.getElementById(id);
    div = document.createElement('div');
    div.id = 'miniature-' + (miniature_count);


    var img = document.createElement('img');
    img.setAttribute('src', picture.url);
    div.append(img);

    if (!picture.realname) {
        picture.realname = "";
    }
    var input = document.createElement('input');
    input.setAttribute('type', 'text');
    input.setAttribute('value', picture.realname);
    input.setAttribute('placeholder', translate('pictureName'));
    input.setAttribute('name', 'pictures[' + picture.url.replace('.', '::') + ']');
    div.appendChild(input);

    var i = document.createElement('i');
    i.classList.add("fa");
    i.classList.add("fa-minus-square");
    i.setAttribute('aria-hidden', 'true');

    var a = document.createElement('a');
    a.classList.add("remove-label");
    a.setAttribute('onclick', 'miniature_remove('+miniature_count+')');
    /*a.id= 'miniature-remove-'+(miniature_count);*/
    a.appendChild(i);
    div.appendChild(a);


    container.appendChild(div);

}
function tmp_upload(id, iconId, container){
    let json_answer;
    start_loading(iconId);
    files = document.getElementById(id).files;
    const csrf = document.getElementsByName('_csrf-token')[0].content;
    /*console.log(csrf);*/
    formData = new FormData();
    const headers = new Headers({
        'X-CSRF-TOKEN': csrf,
        'accept': 'application/json'
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
        console.log(response);
        if (!response.ok) {
            if(response.status===422){
                response.json().then(data=>{
                    for (let i in data['errors']){
                        for (let j in data['errors'][i]) {
                            alert_warning(translate('validationFailed') + data['errors'][i][j]);
                            console.log(data['errors'][i][j][0]);

                        }
                    }
                    stop_loading(iconId);
                    document.getElementById(id).value="";
                })
            }else {
                throw Error(response.statusText);
            }
        }else{
            return response.json();
        }
    }).then(data => {
        // Work with JSON data here
        /* console.log(data);*/
        json_answer = data;
        document.getElementById(id).value = "";
        stop_loading(iconId);
        //var json = JSON.parse(data);// here data is your response$
        console.log(data);
        for (var key in data) {
            console.log(data[key]);
            create_miniature(container, data[key]);
        }
    }).catch(function(error) {
         /*   console.log('Il y a eu un problème avec l\'opération fetch: ' + error.message);*/
        alert_warning(translate('problemConnecting') + error.message);
        stop_loading(iconId);
    });


}

function listen_input(input) {
    input.addEventListener("focusout", function (e) {
        var quantity = 0;
        console.log('focusout of quantity');
        var quantities = document.getElementsByClassName('quantity-to-sum');
        for (var i = 0; i < quantities.length; ++i) {
            var item = quantities[i];
            quantity += Number(item.value);
        }
        console.log('total quantity: ' + quantity);
        if (quantity === 100) {
            enable_submit();
        } else {
            disable_submit();
        }
    });
}

function enable_submit() {
    var submit = document.getElementById('submit');
    submit.setAttribute('class', 'insert-button')
    submit.disabled = false;
}

function disable_submit() {
    var submit = document.getElementById('submit');
    submit.setAttribute('class', 'disabled insert-button')
    submit.disabled = true;
}
