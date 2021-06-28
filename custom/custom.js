function saveFile() {

    const text = document.getElementById('text');
    let data = text.value;
    const category_text = document.getElementById('category_select');
    let category = category_text.value;

    let total_temp_length = (localStorage.length);
    let increment = total_temp_length + 1;

    let myData = {
        category: category,
        data: data
    }
    localStorage.setItem(increment, JSON.stringify(myData));
// console.log(localStorage.getItem(localStorage.key(1)))

    console.log("Added");
    document.getElementById("show_box").innerHTML +=
        ' <div class="alert alert-success alert-dismissible">\n' +
        '    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\n' +
        '    <strong>Added</strong> .\n' +
        '  </div>';

    document.getElementById('text').value = '';



}


function updateFile() {
    const hidden_value = document.getElementById('id_hidden');
    let tmp_hidden = hidden_value.value;

    // let temp_data_swap = JSON.parse( localStorage.getItem( id ) );
    let temp_id = tmp_hidden;
    const text = document.getElementById('edit_text');
    let data = text.value;
    const edit_category = document.getElementById('edit_category_select');
    let category_edit = edit_category.value;

    let myData = {
        category: category_edit,
        data: data
    }


    // console.log(myData);
    localStorage.setItem(temp_id, JSON.stringify(myData));
    console.log("Updated");
    location.reload();

}

function removeFile() {
    const hidden_value = document.getElementById('id_hidden');
    let tmp_hidden = hidden_value.value;
    let temp_id = tmp_hidden;
    localStorage.removeItem(temp_id);

    console.log("Deleted Success Fully")
    location.reload();
}

function uploadCategory() {


    let counter = JSON.parse(localStorage.getItem("category"));

    // console.log(counter.length);

    const text = document.getElementById('category');
    let data = text.value;
    let total_temp_length;
    let increment;
    if (localStorage.hasOwnProperty("category")){
        total_temp_length = (counter.length);
         increment = total_temp_length + 1;
    }
     else {
         total_temp_length = 0;
         increment=total_temp_length+1;
     }



    // Parse any JSON previously stored in allEntries


    let existingEntries = JSON.parse(localStorage.getItem("category"));
    if (existingEntries == null) existingEntries = [];

    let entry = {
        category_number: increment,
        data: data
    };
    localStorage.setItem("category", JSON.stringify(entry));
    // Save allEntries back to local storage
    existingEntries.push(entry);
    localStorage.setItem("category", JSON.stringify(existingEntries));


    console.log("Added");
    document.getElementById("show_box").innerHTML +=
        ' <div class="alert alert-success alert-dismissible">\n' +
        '    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\n' +
        '    <strong>Category Added</strong> .\n' +
        '  </div>';

    document.getElementById('category').value = '';
location.reload();

}

function changeCheckbox(id) {
    let decider = document.getElementById(id);
    if (decider.checked) {
        let temp_id = id;
        let temp_data = JSON.parse(localStorage.getItem(temp_id));

        document.getElementById('edit_text').value = temp_data.data;
        document.getElementById('id_hidden').value = temp_id;

        let theDiv = document.getElementById("edit_category_select");
        theDiv.innerHTML += '<option value=' + temp_data.category + '>' + temp_data.category + '</option>';

        let counter = JSON.parse(localStorage.getItem("category"));

        for (let i = 0; i < counter.length; i++) {

            let item = counter[i].data;
            theDiv.innerHTML += '<option value=' + item + '>' + item + '</option>';

        }
    } else {
        alert('unchecked');
    }
}
function editCategory(id){
    let counter = JSON.parse(localStorage.getItem("category"));
    let temp_id = id;
    let item = counter[temp_id].data;
    document.getElementById('edit_text_category').value =item;
    document.getElementById('id_category_hidden').value =id;

}
function editCategorydataset(){


    let counter = JSON.parse(localStorage.getItem("category"));



    const text = document.getElementById('edit_text_category');
    const id_temp = document.getElementById('id_category_hidden');
    let data = text.value;
    let temp_id = id_temp.value;
    let item = counter[temp_id].category_number;


    // Parse any JSON previously stored in allEntries


    let existingEntries = JSON.parse(localStorage.getItem("category"));
    if (existingEntries == null) existingEntries = [];



    // Save allEntries back to local storage
    existingEntries[temp_id].data=data;


    localStorage.setItem("category", JSON.stringify(existingEntries));
    location.reload()
}
function removeCategory(id){
    let counter = JSON.parse(localStorage.getItem("category"));
    let temp_id=id;
    counter = [];
    localStorage.removeItem(counter[temp_id])

}
function delete_for_paginate (){
    // const text = document.getElementById('paragraph');
    const text=document.getElementById("paragraph").textContent;
    let i;
    if (localStorage.hasOwnProperty("category")){
        i=1;
    }
    else {
        i=0;
    }
    for ( i ; i < localStorage.length; i++) {


        let key = localStorage.key(i);

        let item = JSON.parse(localStorage.getItem(key));
        let temp_data = item.data;
        console.log(temp_data.localeCompare(text));
        if (temp_data.localeCompare(text)){
            console.log(key)
            localStorage.removeItem(key);
            location.reload();
            break;
        }
        else {
            location.reload()
            console.log("not found")
        }
    }


}

function editPaginate(){


    const text=document.getElementById("paragraph").textContent;

    let theDiv = document.getElementById("edit_category_select");
    //

    let i;
    if (localStorage.hasOwnProperty("category")){
        i=1;
    }
    else {
        i=0;
    }
    for ( i ; i < localStorage.length; i++) {


        let key = localStorage.key(i);

        let item = JSON.parse(localStorage.getItem(key));
        let temp_data = item.data;
        if (temp_data.localeCompare(text)) {
            document.getElementById('id_hidden').value = key;
            document.getElementById('edit_text').value = text;
            theDiv.innerHTML += '<option value=' + item.category + '>' + item.category + '</option>';
            break;
        }


    }

    //

    let counter = JSON.parse(localStorage.getItem("category"));

    for (let i = 0; i < counter.length; i++) {
        let item = counter[i].data;
        theDiv.innerHTML += '<option value=' + item + '>' + item + '</option>';

    }




}
function updatePaginate(){
    const hidden_value = document.getElementById('id_hidden');
    let tmp_hidden = hidden_value.value;
    console.log(tmp_hidden)

    // let temp_data_swap = JSON.parse( localStorage.getItem( id ) );
    let temp_id = tmp_hidden;
    const text = document.getElementById('edit_text');

    let data = text.value;

    const edit_category = document.getElementById('edit_category_select');
    let category_edit = edit_category.value;

    let myData = {
        category: category_edit,
        data: data
    }


    // console.log(myData);
    localStorage.setItem(temp_id, JSON.stringify(myData));
    console.log("Updated");
    location.reload();
}
