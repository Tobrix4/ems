<div class="content py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-outline card-primary rounded-0 shadow">
                <div class="card-header rounded-0">
                        <h4 class="card-title">Hledej svůj záznam</h4>
                </div>
                <div class="card-body">
                    <form action="" id="search_record">
                        <div class="form-group">
                            <label for="code" class="control-label text-navy">Zdravotní Kód</label>
                            <input type="text" class="form-control form-control-border" autofocus placeholder="Hledej podle kódu" name="code">
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label text-navy">Zdravotní Jméno</label>
                            <input type="text" class="form-control form-control-border" placeholder="Hledejte podle jména" name="name">
                            <small class="px-2 text-muted"><em>Formát: (Příjmení, Jméno)</em></small>
                        </div>
                        <div class="form-group mt-3 text-center">
                            <button class="btn btn-primary btn-flat col-4"><i class="fa fa-search"></i> Hledat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#search_record').submit(function(e){
            e.preventDefault()
            if($('[name="code"]').val() == '' && $('[name="name"]').val() == ''){
                alert_toast(" Vyhledávácí pole jsou prázdná","error");
                return false;
            }
            location.href="./?page=search_result&"+$(this).serialize();
        })
    })
</script>