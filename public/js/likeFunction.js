$(function() {
    var action;
    var color;
    var current;
    var parent;

    $("#like #likeReply").each(function(index) {
        $(this).click(function() {
            current = $(this);
            parent = current.parent();
            if (user_id != null) {
                var reply_id = current.attr("name");
                color = current.css("color");

                if (color == "rgb(0, 0, 0)") {
                    action = "like";
                } else if (color == "rgb(0, 0, 255)") {
                    action = "unlike";
                }

                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        )
                    }
                });

                $.ajax({
                    url: "/likes/store",
                    type: "post",
                    data: {
                        action: action,
                        reply_id: reply_id,
                        user_id: user_id
                    },
                    success: function(data) {
                        console.log(data);

                        if (data.action == "like") {
                            current.css("color", "blue");
                        } else if (data.action == "unlike") {
                            current.css("color", "black");
                        }

                        parent.find(".countReply").html(data.likeCount + " Likes");
                    }
                });
            } else {
                window.location = "{{ route('login') }}";
            }
        });
    });
});
