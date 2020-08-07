
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


function autocomplete(inp, arr, level) {
/*    arr=[];
    for (i = 0; i < arr.length; i++) {
        arr.push(categories[i]['name']);
    }*/

    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    var currentFocus;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {
        var a, b, i, val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) { return false;}
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            if (arr[i]['name'].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");
                /*make the matching letters bold:*/
                b.innerHTML = "<strong>" + arr[i]['name'].substr(0, val.length) + "</strong>";

                b.innerHTML += arr[i]['name'].substr(val.length);
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input id='"+arr[i]['id']+"' type='hidden' value='" + arr[i]['name'] + "'>";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function(e) {
                    console.log('clicked, level:'+level);
                    for(var i=(level+1);  i<10; i++){
                        console.log('trying to find:'+i);
                        var levelBelow = document.getElementById( 'level-'+i);
                        if(levelBelow){
                            console.log('remove: level-'+i);
                            levelBelow.remove();
                        }else{
                            console.log('nothing below, breaking');
                            break;
                        }
                    }
                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value;
                    console.log(this.getElementsByTagName("input")[0].id);
                    var parentID=this.getElementsByTagName("input")[0].id;

                    fetchJson('GET', 'http://glaze.cera.chat/en/category/'+parentID, function(data){
                        console.log('fetched:');
                        console.log(data);
                        if(data.length!==0) {
                            div = document.getElementById('categories');
                            subdiv = document.createElement('div');
                            subdiv.setAttribute("class", "autocomplete");
                            subdiv.setAttribute("level", (level+1));
                            subdiv.setAttribute("id", 'level-'+(level+1));


                            input = document.createElement('input');
                            input.setAttribute('name', 'category[' + parentID + ']');
                            input.setAttribute("required", "required");
                            input.setAttribute("type", "text");
                            input.setAttribute("placeholder", "Sub-categories");
                            input.setAttribute("id", "add-categories-" + parentID);

                            i= document.createElement('i');
                            i.setAttribute("class", "fa fa-minus-square");
                            i.setAttribute("aria-hidden", "true");
                            a= document.createElement('a');
                            a.setAttribute("id", "categories-remove-" + (level+1));
                            a.setAttribute("class", "remove-categories");
                            a.setAttribute("onclick", "remove_category("+(level+1)+")");
                            a.appendChild(i);


                            subdiv.appendChild(input);
                            subdiv.appendChild(a);

                            div.appendChild(subdiv);

                            autocomplete(document.getElementById("add-categories-" + parentID), data, (level+1));
                        }
                    });



                    /*close the list of autocompleted values,
                    (or any other open lists of autocompleted values:*/
                    closeAllLists();
                });
                a.appendChild(b);
            }
        }
    });
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
            increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
            decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
            }
        }
    });
    function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }
    function closeAllLists(elmnt) {
        /*close all autocomplete lists in the document,
        except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}