
$(document).ready(function () {
    fetchNote(1);
})
// open modal add_note, add_cate, delete_note
$('#button_add_note').on('click', function () {
    $('#addNoteModal').modal();
});
//select category show note
$(document).on('click', '.cateBtn', function () {
    var id = $(this).data('cid');
    fetchNote(id);
})
$(document).on('click', '.noteText', function (e) {
    // e.preventDefault();
    var nid = $(this).data('txt_id');
    var upid = '#uptbtn' + nid;
    $(upid).css('display', 'block');
    $(upid).on('click', function () {
        var tid = '#titleN' + nid;
        var did = '#descN' + nid;
        var title = $(tid).text();
        var desc = $(did).text();
        if (title == '') {
            alert("Note title can not be empty");
        } else {
            $.ajax({
                url: "updateNote.php",
                type: "POST",
                data: { 'title': title, 'desc': desc, 'nid': nid },
                success: function (data) {
                    // alert("Note is updated");
                }
            })
            //fetchNote($(this).data('cate_id'));
            fetchNote(1);
        }
    })
})
// insert note
$('#button_insert_note').on('click', function () {
    var title = $('#title').val();
    var desc = $('#desc').val();
    var cateChoice = $('#cateChoice').val();
    if (title == '') {
        alert("Note title can not be empty");
    } else {
        $.ajax({
            url: "insertNote.php",
            type: "POST",
            data: {
                'title': title,
                'desc': desc,
                'cateChoice': cateChoice
            },
            dataType: "text",
            success: function (data) {
                switch (data) {
                    case '2':
                        alert("Insert Failed");
                        break;
                    case '1':
                        alert("Insert Successfully");
                        $('#title').val('');
                        $('#desc').val('');
                        break;
                    case '3':
                        alert("Title has aldready existed");
                        break;
                }
                fetchNote(1);
            }
        });
    }
})
//delete note
$(document).on('click', '.delbtn', function () {
    var nid = $(this).data('deln_id');
    $.ajax({
        url: "deleteNote.php",
        type: "POST",
        data: { 'nid': nid },
        success: function (data) {
            alert("Note is deleted");
        }
    })
    fetchNote(1);
})
// fetchNote gui
function fetchNote(cateid = 1) {
    $.ajax({
        url: "selectNote.php",
        type: "POST",
        data: {
            'cateid': cateid
        },
        dataType: "json",
        success: function (data) {
            $('#noteList').html(data.html);
        }
    });
}