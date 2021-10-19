$(document).ready(()=>{
    $(document).on('click','#blog-add-fav', (e)=>{
        e.preventDefault();

        var post = {};
        post['method'] = "add";
        post['postId'] = $(e.target).data('id');

        BX.ajax.post(
            '/ajax/favorite.php',
            post,
            function () {
                alert("Ok");
            }
        );

    });
})
