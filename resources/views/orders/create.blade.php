<form action="/order" method="POST">
    @csrf
    <input type="text" placeholder="ФИО" name="full_name">
    <br>
    <input type="text" placeholder="Комментарий" name="comment">
    <br>
    <input type="text" placeholder="Артикул товара" name="article_number">
    <br>
    <input type="text" placeholder="Бренд товара" name="brend">
    <br>
    <button>Отправить</button>
</form>