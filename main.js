$(document).ready(function(){
    //Обработка отправки формы
    $("#documentForm").submit(function(event){
        event.preventDefault();
    
        //Получение значений
        var title = $("#title").val();
        var content = $("#content").val();
    
        //Отправка на сервер
        $.ajax({
            type:"POST",
            url:"create_documentation.php",
            data:{
                title: title,
                content: content
            },
            success:function(response){
                //Обработка ответа от сервера
                if(response.success){
                    //Документ создан, обновляем лист
                    loadDocumentationList();
                }else{
                    console.log("Ошибка при создании документации");
                }
            },
            error: function(){
                console.log("Ошибка при отправке AJAX-запроса");
            }
        });
    });
    //Загрузка документации при загрузке страницы
    loadDocumentationList();
})

function loadDocumentationList(){
    $.ajax({
        type:"GET",
        url:"documentation_list.php",
        success:function(response){
            //Вставка списка докум. в div с id documentationList
            $("#documentationList").text(response);
        },
        error:function(){
            console.log("Ошибка при загрузке списка документации");
        }
    });
}