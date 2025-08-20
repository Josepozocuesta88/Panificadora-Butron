@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Términos y Condiciones</li>
                    </ol>
                </div>
                <h4 class="page-title fw-bold">Términos y Condiciones</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">1. OBJETO</h3>
                            <p>El presente documento regula el uso del sitio web de REPOSTERIA FLORY'S VERGARA, SLU. (en adelante, "la Empresa"), así como las condiciones de acceso y utilización por parte de los usuarios. Al acceder y navegar por este sitio web, el usuario acepta plenamente y sin reservas todas y cada una de las disposiciones incluidas en estos Términos y Condiciones.</p>
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">2. ACCESO Y USO DEL SITIO WEB</h3>
                            <p>El acceso y uso de este sitio web es gratuito para los usuarios y no exige el registro previo. El usuario se compromete a utilizar el sitio web, sus servicios y contenidos de conformidad con la ley, la moral, el orden público y los presentes Términos y Condiciones.</p>
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">3. PROPIEDAD INTELECTUAL E INDUSTRIAL</h3>
                            <p>Todos los contenidos del sitio web, incluyendo textos, imágenes, gráficos, logotipos, iconos, software, nombres comerciales, marcas o signos distintivos, son propiedad de la Empresa o de terceros, estando protegidos por la legislación vigente en materia de propiedad intelectual e industrial. Queda prohibida la reproducción, distribución o modificación, total o parcial, sin autorización expresa de la Empresa.</p>
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">4. RESPONSABILIDAD</h3>
                            <p>La Empresa no se responsabiliza de los daños o perjuicios que pudieran derivarse del uso de la información, contenidos y servicios incluidos en este sitio web, ni de la disponibilidad y continuidad del funcionamiento del mismo. El usuario es responsable del uso adecuado del sitio web y de la información contenida en él.</p>
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">5. ENLACES A TERCEROS</h3>
                            <p>Este sitio web puede contener enlaces a páginas externas de terceros. La Empresa no asume ninguna responsabilidad sobre los contenidos, informaciones o servicios que pudieran aparecer en dichos sitios, que tendrán exclusivamente carácter informativo y que en ningún caso implican relación alguna entre la Empresa y las personas o entidades titulares de tales contenidos o titulares de los sitios donde se encuentren.</p>
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">6. MODIFICACIONES</h3>
                            <p>La Empresa se reserva el derecho de modificar, actualizar o eliminar en cualquier momento y sin previo aviso los contenidos, servicios y condiciones de acceso y uso del sitio web.</p>
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">7. LEGISLACIÓN APLICABLE Y JURISDICCIÓN</h3>
                            <p>Estos Términos y Condiciones se rigen por la legislación española. Para la resolución de cualquier controversia que pudiera derivarse del acceso o uso del sitio web, las partes se someten a los Juzgados y Tribunales de Córdoba, renunciando a cualquier otro fuero que pudiera corresponderles.</p>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold mb-1">Datos de contacto</h6>
                            <p>REPOSTERIA FLORY'S VERGARA, SLU. C/ Pintor Vicente Piernagorda, s/n, - 14850 Baena (Córdoba). E-mail: <a href="mailto:administracion@florys.es">administracion@florys.es</a></p>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-12-->
        </div> <!-- end rowcol-->
    </div>
    <!-- end -->
</div>
@endsection