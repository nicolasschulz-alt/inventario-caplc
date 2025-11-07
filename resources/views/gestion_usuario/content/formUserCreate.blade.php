<style>
    #modal_registrar_usuario .form-group select,
    #modal_registrar_usuario .form-group option,
    #modal_registrar_usuario .form-group input,
    #modal_registrar_usuario .form-group textarea,
    #modal_registrar_usuario .form-group label
    {
        /* font-size: 14px; */
        color: #3a3b45;
    }
    #modal_registrar_usuario .form-group label{
        font-weight: 700;
        color: #4e73df;
        font-size: 14px;
    }
    
    .lbl-chck{
        font-size: 16px !important;
        font-weight: 600 !important;
        user-select: none;
        text-decoration: none !important;
        color: #3a3b45 !important;
    }
    .lbl-chck:hover{
        text-decoration: underline;
        border-bottom: 1px solid #3a3b45;
        /* cursor: pointer; */
    }
    .lbl-chck-active{
        /* font-weight: 700 !important; */
        border-bottom: 1px solid #1cc88a !important;
        
    }
    .col_overflow_auto{
        overflow: auto;
    }
        .no-margen-bottom{
        margin-bottom: 0px !important;
        }
    .ancho-max-content{
        width: max-content;
    }
    .ancho-wbk-fill-av{
        width: -webkit-fill-available;
    }
    .p-tabla-head{
        padding: 3px 12px !important;
        font-weight: 500;
        color: #fff;
        background-color: #4e73df;
        border: 1px solid #4e73df !important;
    }

    .is-valid{
        /* border-color: #1cc88a !important; */
        border: 2px solid #1cc88a !important;
        /* font-weight: 700 !important; */
    }
    .is-valid:focus{
        border-color: #1cc88a !important;
        box-shadow: 0 0 0 .2rem rgba(28, 200, 138, .25) !important;
    }
    .is-invalid{
        border: 1px solid #e74a3b !important;
        /* font-weight: 700 !important; */
    }
    .is-invalid:focus{
        border-color: #e74a3b !important;
        box-shadow: 0 0 0 .2rem rgb(231 74 59 / 25%) !important;
    }

    
    /*quita check verde de select (lo agrega bootstrap los que tienen la clase is-valid) */
    select.form-control.is-valid,
    select.form-control.is-invalid
    {
        padding: .375rem .75rem !important;
        background-image: none !important;
    }
    

    /* ancho select2 */
    .select2-container{
        /* width: 100% !important; */
    }
    .select2-selection__clear{
        margin-right: 30px !important;
        color: black !important;
    }
    .select2-container .select2-selection--multiple .select2-selection__rendered{
        display: block !important;
    }
    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice__remove{
        border: 1px solid #bdc6d0 !important;
    }
    .select2-container .select2-selection--multiple .select2-selection__rendered {
        display: flex !important;
        flex-wrap: wrap !important;
    }
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
        color: #3a3b45 !important;
    }
    
    .campo-selected{
        border: 2px solid #1cc88a !important;
        font-weight: 700 !important;
    }
</style>

<form action="{{route('usuario.permiso_user_create')}}" id="form_registrar_user" user_id="{{$user_id}}" route="{{ route('usuario.permiso_user_create') }}" novalidate>
    @csrf
    <div class="row">
        
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label for="sistema_id">Sistema</label>
                <select class="form-control" id="sistema_id" name="sistema_id">
                    <option value=""></option>
                    @foreach ($sistemas_disponibles as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label for="rol_id">Rol</label>
                <select class="form-control" id="rol_id" name="rol_id">
                    <option value=""></option>
                    @foreach ($roles as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label>Establecimiento</label>
                <div class="row">
                    @foreach ($establecimiento as $item)
                        <div class="col-md-4 col-sm-12">
                            <input type="checkbox" id="establecimiento_id_{{$item->id}}" value="{{$item->id}}"> <label for="establecimiento_id_{{$item->id}}" class="text_black font-weight-normal">{{$item->nombre}}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <button type="button" class="btn btn-success btn-md" id="btn_guardar_form_user" user_id="{{$user_id}}" route="{{ route('usuario.permiso_user_create') }}" {{count($sistemas_disponibles) <= 0 ? 'disabled' : ''}}>Guardar</button>
        </div>
    </div>
</form>

<script>
    //var cerrar_modal_reg_user = false;
    $(document).ready(function () {

        /* $('#modal_registrar_usuario .close').on('click', function (event) {
           console.log(event);
           event.preventDefault(); // Previene el cierre del modal
           event.stopPropagation(); // Detiene la propagación del evento

           if (!cerrar_modal_reg_user){
                Swal.fire({
                    title: "¿Seguro que desea salir?",
                    text: "-Se perderán los datos ingresados",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, salir",
                    cancelButtonText: "No",
                }).then((result) => {
                    if (result.isConfirmed) {
                        cerrar_modal_reg_user = true;
                        $('#modal_registrar_usuario').modal('hide');
                        //$('#body_modal_registrar_usuario').html('');
                        console.log('confirma salir');
                        
                    } else {
                        cerrar_modal_reg_user = false;
                    }
                });
           }

        }); */
        
        $('#modal_registrar_usuario').on('hidden.bs.modal', function () {
            console.log('El modal crear ha sido cerrado.');
            $('#body_modal_registrar_usuario').html('');
        });


        $('.ipt_slc_value').on('input', function (event) {
            //console.log(event);
            event.preventDefault();
            let val_this = $(this).val();
            val_this = val_this.trim();
            if (val_this){
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(this).removeClass('is-valid is-invalid');
            }
        });




        //select2

        //buscar ip

        //buscar libre
        $('#sistema_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            //language: 'es',
            language: {
                'noResults': function(){
                    return 'No hay sistemas disponibles para asignar';
                }
            },
            dropdownParent: $("#form_registrar_user")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        }).on('change',function(e){
            if ($(this).val()){
                $(this).closest('td').next('td').find('select').prop('disabled',false).find('option:selected').prop('placeholder','-').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).addClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',false).val('');
            } else {
                $(this).closest('td').next('td').find('select').prop('disabled',true).find('option:selected').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',true).val('');
            }
        });
        $('#rol_id').select2({
            placeholder: '',
            allowClear: true,
            theme: 'bootstrap4',
            //language: 'es',
            language: {
                'noResults': function(){
                    return 'No hay roles disponibles para asignar';
                }
            },
            dropdownParent: $("#form_registrar_user")
        }).on('select2:open', function (e) {
            document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
        }).on('change',function(e){
            if ($(this).val()){
                $(this).closest('td').next('td').find('select').prop('disabled',false).find('option:selected').prop('placeholder','-').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).addClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',false).val('');
            } else {
                $(this).closest('td').next('td').find('select').prop('disabled',true).find('option:selected').prop('selected', false);
                $(`[aria-controls="select2-${e.target.id}-container"]`).removeClass('is-valid');
                $(this).closest('tr').find('input[type="text"]').prop('disabled',true).val('');
            }
        });



        $('#btn_guardar_form_user').on('click', function (event) {
            event.preventDefault();

            return_ = true;
           if (!document.getElementById('sistema_id').value){

                return_ = false;
                $('#sistema_id').removeClass('is-valid is-invalid').addClass('is-invalid').focus();
                Swal.fire({
                    title: "Complete los campos requeridos!",
                    text: "",
                    icon: "warning"
                });

            }

            if (!document.getElementById('rol_id').value){

                return_ = false;
                $('#rol_id').removeClass('is-valid is-invalid').addClass('is-invalid').focus();
                Swal.fire({
                    title: "Complete los campos requeridos!",
                    text: "",
                    icon: "warning"
                });

            }

            if (!return_){
                return false;
            }

            const user_id = this.getAttribute('user_id');
            /* let establecimientos = [];
            $('input[id^=establecimiento_id_]').each(function (index, element) {
                if ($(element).prop('checked')){
                    establecimientos.push($(element).val());
                }
            });
            console.log(establecimientos);
            return false; */

            const objeto_data = {
                user_id: user_id,
                sistema_id: document.getElementById('sistema_id').value,
                rol_id: document.getElementById('rol_id').value,
                _token:  document.querySelector('meta[name="csrf-token"]').content
            };

            console.log(objeto_data);

            const route = this.getAttribute('route');

            Swal.fire({
                title: "¿Desea Guardar?",
                text: "",
                icon: "question",
                showCancelButton: true,
                //confirmButtonColor: "#3085d6",
                //cancelButtonColor: "#d33",
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-secondary"
                },
                confirmButtonText: "Sí, Guardar",
                cancelButtonText: "Cancelar",
            }).then(async(result) => {      
                if (result.isConfirmed && route) {

                    try {
                        const response = await fetch(route, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(objeto_data)
                        });

                        if (response.redirected){
                            location.replace("/login");
                            throw new Error('Redireccionado');
                        }
                        if (!response.ok){
                            throw new Error('Error al obtener datos');
                        }
                        const data = await response.json();
                        console.log(data);
                        if (data.status == 201){

                            console.log('Datos insertados correctamente:', data);

                            /* await cargarTablaPermisoUser();

                            loader('hide');

                            Swal.fire({
                                title: "Guardado con éxito",
                                text: "",
                                icon: "success"
                            })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    $('#modal_registrar_usuario').modal('hide');
                                }
                            }); */

                            $('#modal_registrar_usuario').modal('hide');

                            loader('stop');
                            Swal.fire({
                                icon: "success",
                                title: "Guardado con éxito",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            await cargarTablaPermisoUser();
                            loader('continue');

                        } 
                    } catch (error) {
                        console.error(error);
                        Swal.fire({
                            icon: "error",
                            title: "Error al Guardar",
                            text: ""
                        });
                    }
                    
                } else {

                    Swal.fire({
                        icon: "info",
                        title: "Acción Cancelada",
                        text: ""
                    });
                    
                }
            });

        });


    });

    
</script>