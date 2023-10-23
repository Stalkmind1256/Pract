$(document).ready(function(){
    // Обработка отправки формы
    $("#documentForm").submit(function(event){
        event.preventDefault();

        // Получение значений
        var surname = $("#surname").val();
        var title = $("#title").val();
        var resalt = $("#resalt").val();
        var marks = $("#marks").val();
        var dated = $("#dated").val();

        // Отправка на сервер
        $.ajax({
            url: "create_documentation.php",
            type: "POST",
            data: {
                surname: surname,
                title: title,
                resalt:resalt,
                marks:marks,
                dated:dated
            },
            success: function(response) {
                // Обработка ответа от сервера
                if(response.success) {
                    // Документ создан, обновляем список
                    loadDocumentationList();
                } else {
                    console.log("Ошибка при создании документации");
                }
            },
            error: function() {
                console.log("Ошибка при отправке AJAX-запроса");
            }
        });
    });

    // Загрузка документации при загрузке страницы
    loadDocumentationList();
});

function loadDocumentationList() {
    $.ajax({
        type: "GET",
        url: "documentation_list.php",
        success: function(response) {
            // Вставка списка документов в div с id documentationList
            $("#documentationList").html(response);
        },
        error: function() {
            console.log("Ошибка при загрузке списка документации");
        }
    });
}