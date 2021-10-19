$(document).ready(() => {
    $(document).on('click', '#blog-add-fav', (e) => {
        e.preventDefault();

        BX.ajax.runComponentAction('imrg:favorite',
            ($(e.target).data('fav'))? 'removeFavorite' :'addFavorite', { // Вызывается без постфикса Action
                mode: 'class',
                data: {post: {post_id: $(e.target).data('id')}}, // ключи объекта data соответствуют параметрам метода
            })
            .then(function (response) {
                if (response.status === 'success') {
                    alert('Success');
                    window.location.reload();
                }
            });
    });
})
