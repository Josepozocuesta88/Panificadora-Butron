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
            <li class="breadcrumb-item active">Política de Privacidad</li>
          </ol>
        </div>
        <h4 class="page-title fw-bold">Política de Privacidad</h4>
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
              <h3 class="mb-3 text-primary fw-bold">1. INFORMACIÓN AL USUARIO</h3>
              <h5 class="fw-bold mb-2">¿Quién es el responsable del tratamiento de tus datos personales?</h5>
              <p>REPOSTERIA FLORY'S VERGARA, SLU. (<span class="fw-bold">B14489504 </span>) es el <span class="fw-bold">RESPONSABLE</span> del tratamiento de los datos personales del USUARIO y le informa de que estos datos serán tratados de conformidad con lo dispuesto en el Reglamento (UE) 2016/679, de 27 de abril (GDPR), y la Ley Orgánica 3/2018, de 5 de diciembre (LOPDGDD).</p>

              <br>
              <h5 class="fw-bold mb-2">¿Para qué tratamos tus datos personales y por qué lo hacemos?</h5>
              <p>Según el formulario donde hayamos obtenido sus datos personales, los trataremos de manera confidencial para alcanzar los siguientes fines:</p>
              <p class="mb-1"><span class="fw-bold">En el formulario Contacto:</span></p>
              <ul>
                <li>Dar respuesta a las consultas o cualquier tipo de petición que sea realizada por el usuario a través de cualquiera de las formas de contacto que se ponen a su disposición en la página web del responsable. <span class="text-muted">(por el interés legítimo del responsable, art. 6.1.f GDPR)</span></li>
                <li>Realizar análisis estadísticos y estudios de mercado. <span class="text-muted">(por el interés legítimo del responsable, art. 6.1.f GDPR)</span></li>
              </ul>

              <br>
              <h5 class="fw-bold mb-2">¿Durante cuánto tiempo guardaremos tus datos personales?</h5>
              <p>Se conservarán durante no más tiempo del necesario para mantener el fin del tratamiento o existan prescripciones legales que dictaminen su custodia y cuando ya no sea necesario para ello, se suprimirán con medidas de seguridad adecuadas para garantizar la anonimización de los datos o la destrucción total de los mismos.</p>

              <br>
              <h5 class="fw-bold mb-2">¿A quién facilitamos tus datos personales?</h5>
              <p>No está prevista ninguna comunicación de datos personales a terceros salvo, si fuese necesario para el desarrollo y ejecución de las finalidades del tratamiento, a nuestros proveedores de servicios relacionados con comunicaciones, con los cuales el RESPONSABLE tiene suscritos los contratos de confidencialidad y de encargado de tratamiento exigidos por la normativa vigente de privacidad.</p>

              <br>
              <h5 class="fw-bold mb-2">¿Cuáles son tus derechos?</h5>
              <p>Los derechos que asisten al USUARIO son:</p>

              <br>
              <ul>
                <li><span class="fw-bold">Derecho a retirar el consentimiento</span> en cualquier momento.</li>
                <li><span class="fw-bold">Derecho de acceso, rectificación, portabilidad y supresión</span> de sus datos, y de limitación u oposición a su tratamiento.</li>
                <li><span class="fw-bold">Derecho a presentar una reclamación</span> ante la autoridad de control (<a href="https://www.aepd.es" target="_blank">www.aepd.es</a>) si considera que el tratamiento no se ajusta a la normativa vigente.</li>
              </ul>

              <br>
              <h6 class="fw-bold mb-1">Datos de contacto para ejercer sus derechos:</h6>
              <p>REPOSTERIA FLORY'S VERGARA, SLU. C/ Pintor Vicente Piernagorda, s/n, - 14850 Baena (Córdoba). NIF: <span class="fw-bold">B14489504 </span> E-mail: <a href="mailto:administracion@florys.es">administracion@florys.es</a></p>
            </div>

            <div class="mb-4">
              <h3 class="mb-3 text-primary fw-bold">2. CARÁCTER OBLIGATORIO O FACULTATIVO DE LA INFORMACIÓN FACILITADA POR EL USUARIO</h3>
              <p>Los USUARIOS, mediante la marcación de las casillas correspondientes y la entrada de datos en los campos, marcados con un asterisco (*) en el formulario de contacto o presentados en formularios de descarga, aceptan expresamente y de forma libre e inequívoca, que sus datos son necesarios para atender su petición, por parte del prestador, siendo voluntaria la inclusión de datos en los campos restantes. El USUARIO garantiza que los datos personales facilitados al RESPONSABLE son veraces y se hace responsable de comunicar cualquier modificación de los mismos.</p>
              <br>
              <p>El RESPONSABLE informa de que todos los datos solicitados a través del sitio web son obligatorios, ya que son necesarios para la prestación de un servicio óptimo al USUARIO. En caso de que no se faciliten todos los datos, no se garantiza que la información y servicios facilitados sean completamente ajustados a sus necesidades.</p>
            </div>

            <div class="mb-4">
              <h3 class="mb-3 text-primary fw-bold">3. MEDIDAS DE SEGURIDAD</h3>
              <p>Que de conformidad con lo dispuesto en las normativas vigentes en protección de datos personales, el RESPONSABLE está cumpliendo con todas las disposiciones de las normativas GDPR y LOPDGDD para el tratamiento de los datos personales de su responsabilidad, y manifiestamente con los principios descritos en el artículo 5 del GDPR, por los cuales son tratados de manera lícita, leal y transparente en relación con el interesado y adecuados, pertinentes y limitados a lo necesario en relación con los fines para los que son tratados.</p>
              <br>
              <p>El RESPONSABLE garantiza que ha implementado políticas técnicas y organizativas apropiadas para aplicar las medidas de seguridad que establecen el GDPR y la LOPDGDD con el fin de proteger los derechos y libertades de los USUARIOS y les ha comunicado la información adecuada para que puedan ejercerlos.</p>
              <br>
              <p>Para más información sobre las garantías de privacidad, puedes dirigirte al RESPONSABLE a través de REPOSTERIA FLORY'S VERGARA, SLU. C/ Pintor Vicente Piernagorda, s/n, - 14850 Baena (Córdoba). NIF: <span class="fw-bold">B14489504 </span> E-mail: <a href="mailto:administracion@florys.es">administracion@florys.es</a></p>
            </div>
          </div> <!-- end card-body-->
        </div> <!-- end card-->
      </div> <!-- end col-12-->
    </div> <!-- end rowcol-->
  </div>
  <!-- end -->
</div>
@endsection