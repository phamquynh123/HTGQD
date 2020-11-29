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
        <h1>Chẩn đoán bệnh</h1>
        <select class="js-example-basic-multiple form-control" name="states[]" multiple="multiple">
            <?php if(isset($pulse)) { foreach($pulse as $value) {?>
                <option value="<?=$value['id']?>"><?=$value['name']?></option>
            <?php }}?>
        </select>
        <form class="group-input" id="form_submit">

        </form>
        <div class="content-result">

        </div>
    </div>
</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script id="handlebars-tag" type="text/x-handlebars-template">
    {{#each pulses}}
    <div class="form-group">
        <label for="">{{name}}</label>
        <input type="text" name="{{id}}" class="form-control m-required" placeholder="Mời nhập trọng số">
        <p class="error"></p>
    </div>
    {{/each}}
    <div class="form-button">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-success">Chẩn đoán</button>
    </div>
</script>
<script id="handlebars-result" type="text/x-handlebars-template">
    <label>Kết quả chẩn đoán : </label>
    <span class="result">{{ symptom }}</span>
    <p>Xác suất : {{weight}} %</p>
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.js-example-basic-multiple').select2();
        $('.js-example-basic-multiple').on('change', function() {
            var pulses = [];
            $(this).find('option:selected').each(function() {
                pulses.push({'id' : $(this).val(), 'name' : $(this).text()});
            });
            var template = $('#handlebars-tag').html();
            var templateScript = Handlebars.compile(template);
            var context = {
                'pulses' : pulses,
            };
            var html = templateScript(context);
            $('#form_submit').html(html);
        })
    });

    $('#form_submit').on('submit', function(e) {
        e.preventDefault();
        let inputs = $(this).find('input');
        if (inputs.length > 3) {
            toastr.error('Không được chọn quá 3 xung');
            return;
        }
        inputs.each(function() {
            if ($(this).val() == '') {
                let error = $(this).parent().find('.error');
                error.css({'display' : 'block'});
                error.text('Không được bỏ trống');
                return;
            } else {
                let error = $(this).parent().find('.error');
                error.css({'display' : 'none'});
                error.text('');
            }
        })
        var form = new FormData(this);
        $.ajax({
            url: '?mod=home&act=post',
            method: 'post',
            dataType:'JSON',
            processData: false,
            contentType: false,
            data:form,
            success:function(response){
                console.log(response);
                var template = $('#handlebars-result').html();
                var templateScript = Handlebars.compile(template);
                var context = {
                    'symptom' : response.symptom,
                    'weight' : response.weight,
                };
                var html = templateScript(context);
                $('.content-result').html(html);
            }
        });
    })
</script>
</html>