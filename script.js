let add = document.querySelector(".add-btn");
let menu = document.querySelector(".list-group");
let textField = document.querySelector(".add-input");

// let editForm = menu.querySelectorAll(".edit-form");





// add.addEventListener("click", function (e) {
//     e.preventDefault();

//     if (textField.value.trim() !== "") {
//         addTodo();
//         console.log("sdsds");
//     } else {
//         console.log("LLER");
//     }
// });


// function addTodo() {
//     menu.innerHTML += `<li>
//     <span>${textField.value}</span>
//     <form action="" class="edit-form">
//            <input type="text" class="edit-input" name="edit">
//            <button class="save-edit"> <i class="fa-solid fa-pencil edit"></i></button>
//     </form>

//     <div class="action-btns">
//         <i class="fa-solid fa-pencil edit"></i>
//         <i class="fa-solid fa-trash-can delete"></i>

//     </div>

//     <div class="exit-edit">
//          <i class="fa-solid fa-xmark"></i>
//     </div>
// </li>
//     `

//     textField.value = "";
//     handeButtons();
    

//     // let buttons = 

//     // editForm.forEach(form => {
//     //     let editBtn = form.querySelector(".edit-btn");
//     //     editBtn.addEventListener("click", function(){
//     //         form.parentElement.style.
//     //     })
//     // });
// }

function handeButtons(){
    let deleteButtons = menu.querySelectorAll(".delete");
    let editButtons = menu.querySelectorAll(".edit");
    let exitBtn = menu.querySelectorAll(".exit-edit");

    deleteButtons.forEach(btn => {
        btn.addEventListener("click", function () {
            console.log("Klick");
            btn.parentElement.parentElement.remove();
        });
    });

    editButtons.forEach(edit => {
        edit.addEventListener("click", function () {
            edit.parentElement.style.display = "none";
            let list = edit.parentElement.parentElement;
            let editForm = list.querySelector(".edit-form");
            let editInput = editForm.querySelector(".edit-input");
            let text = list.querySelector("span");
            let exit = list.querySelector(".exit-edit")
            text.style.display = "none";
            editInput.value = text.innerText;
            editForm.style.display = "flex";
            exit.style.display = "block";

            console.log(edit.parentElement.parentElement);
        })
    });

    exitBtn.forEach(btn => {
        btn.addEventListener("click", function (e) {
            // e.preventDefault();

            let list = btn.parentElement;
            let editForm = list.querySelector(".edit-form");
            let editInput = editForm.querySelector(".edit-input");
            let text = list.querySelector("span");
            let exit = list.querySelector(".exit-edit");
            let actionBtns = list.querySelector(".action-btns");

            text.style.display = "block";
            // text.innerText = editInput.value;
            editForm.style.display = "none";
            exit.style.display = "none";
            actionBtns.style.display = "block";
        })
    });
}

handeButtons();


window.addEventListener("DOMContentLoaded", function(){
    let li = menu.querySelectorAll("li");
    li.forEach(list => {
        let check = list.querySelector(".action-btns .check");
        check.addEventListener("click", function(){
            list.style.backgroundColor = "rgba(0, 159, 0, 0.3)";
        });
    });
});
