// validation.js

document.addEventListener("DOMContentLoaded", function () {
    // Регистрация - проверка пароля и email
    const registerForm = document.querySelector("#registerForm");
    if (registerForm) {
        registerForm.addEventListener("submit", function (e) {
            const password = document.querySelector("#password").value;
            const confirmPassword = document.querySelector("#confirmPassword").value;
            const email = document.querySelector("#email").value;
            const emailPattern = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;

            let errors = [];

            // Проверка пароля
            if (password.length < 8) {
                errors.push("Пароль должен быть не менее 8 символов.");
            }
            if (password !== confirmPassword) {
                errors.push("Пароли не совпадают.");
            }

            // Проверка email
            if (!emailPattern.test(email)) {
                errors.push("Введите корректный email.");
            }

            if (errors.length > 0) {
                e.preventDefault();
                alert(errors.join("\n"));
            }
        });
    }

    // Добавление книги - проверка полей
    const addBookForm = document.querySelector("#addBookForm");
    if (addBookForm) {
        addBookForm.addEventListener("submit", function (e) {
            const title = document.querySelector("#title").value;
            const author = document.querySelector("#author").value;

            if (!title || !author) {
                e.preventDefault();
                alert("Заполните все поля для добавления книги.");
            }
        });
    }
});