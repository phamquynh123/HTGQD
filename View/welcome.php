<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    <style type="text/css">
        #form_submit {
            margin-top : 30px;
        }
        .content-result {
            color : red;
            margin-top : 30px;
        }
        .error {
            display : none;
            color : red;
            font-size : 13px;
            margin-left : 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Hệ thống chẩn đoán bệnh dựa vào y học cổ truyền.  </h1>
        <form action="#" method="POST" role="form" id="search">
            <legend>Tìm kiếm thông tin bệnh nhân.</legend>
            <div class="form-group">
                <label for="">Số CMTND</label>
                <input type="number" class="form-control" id="search-input" placeholder="Input field" name="cmnd">
            </div>      
        
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
        <h4 class="modal-title">Thêm mới bệnh nhân</h4>
      </div>
      <div class="modal-body">
        <form action="?mod=home&act=add" method="POST" role="form" id="Addnew">
            <input type="hidden" name="id" id="id">
            <div class="form-group">
                <label for="">Tên bệnh nhân</label>
                <input type="text" class="form-control" id="name" placeholder="Input field" name='name'>
            </div>
            <div class="form-group">
                <label for="">SĐT bệnh nhân</label>
                <input type="text" class="form-control" id="phone" placeholder="Input field" name='phone'>
            </div>
            <div class="form-group">
                <label for="">Số CMND bệnh nhân</label>
                <input type="text" class="form-control" id="cmnd" placeholder="Input field" name='cmnd'>
            </div>
            <div class="form-group">
                <label for="">Địa chỉ bệnh nhân</label>
                <input type="text" class="form-control" id="address" placeholder="Input field" name='address'>
            </div>
        
            <button type="submit" class="btn btn-primary float-right" id="form-add-edit-submit"></button>
        </form>
      </div>
    </div>

  </div>
</div>



</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js">
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#search').on('submit', function(e) {
            e.preventDefault();
            let input = $('#search-input').val();
            if (input == '') {
                toastr.error('Số CMND không được để trống.');
                return;
            }
            var data = new FormData(this);
            $.ajax({
                url: '?mod=home&act=search',
                method: 'post',
                dataType:'JSON',
                processData: false,
                contentType: false,
                data:data,
                success:function(response){
                    console.log("response", response)
                    $("#myModal").modal('show');
                    if(response == '') {
                        $('.modal-title').html("Thêm mới bệnh nhân");
                        $("#form-add-edit-submit").text("Thêm mới");
                        $("#form").val("add");
                        $('#Addnew').reset()
                    } else {
                        $('.modal-title').html("Thông Tin bệnh nhân");
                        $("#form-add-edit-submit").text("Chẩn đoán bệnh");
                        $('#name').val(response.name);
                        $('#phone').val(response.phone);
                        $('#cmnd').val(response.cmnd);
                        $('#address').val(response.address);
                        $("#id").val(response.id);
                        $('#cmnd').attr('readonly', true);
                    }
                }
            });
        })

        // $('#Addnew').on('submit', function(e) {
        //     e.preventDefault();
        //     var data = new FormData(this);
        //     $.ajax({
        //         url: '?mod=home&act=add',
        //         method: 'post',
        //         dataType:'JSON',
        //         processData: false,
        //         contentType: false,
        //         data:data,
        //         success:function(response){
        //             console.log("response", response)
        //         }
        //     });
        // })
    })
</script>
</html>