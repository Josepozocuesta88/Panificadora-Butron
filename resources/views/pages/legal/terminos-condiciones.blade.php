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
                        <li class="breadcrumb-item active">Condiciones Generales de Venta</li>
                    </ol>
                </div>
                <h4 class="page-title fw-bold">Condiciones Generales de Venta</h4>
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
                            <h3 class="mb-3 text-primary fw-bold">1. Información General</h3>
                            <p> La titularidad de este sitio web www.florys.es (en adelante, "Sitio Web") la ostenta: </p>
                            <br>
                            <p> <strong>Nombre de dominio:</strong> florys.es/</p>
                            <p> <strong>Nombre comercial:</strong> REPOSTERIA FLORY'S</p>
                            <p> <strong>Denominación social:</strong> REPOSTERIA FLORY'S VERGARA, SLU.</p>
                            <p> <strong>NIF:</strong> B56027790</p>
                            <p> <strong>Domicilio social:</strong> C/ Pintor Vicente Piernagorda, s/n</p>
                            <p> <strong>Teléfono:</strong> 957690508</p>
                            <p> <strong>E-mail:</strong> administracion@florys.es</p>
                            <p> <strong>Inscrita en el Registro Mercantil de Córdoba: Hoja CO-35877, Sección 8</strong></p>
                            <br>
                            <p>
                                Este documento regula las condiciones por las que se rige el uso de este Sitio Web y la compra o adquisición de productos y/o servicios en el mismo (en adelante, Condiciones).
                            </p>
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">2. El Usuario</h3>
                            <p>
                                El acceso, la navegación y uso del Sitio Web confiere la condición de usuario (en adelante, "Usuario"), por lo que se aceptan todas las Condiciones aquí establecidas, así como sus ulteriores modificaciones, desde el inicio de la navegación, sin perjuicio de la aplicación de la normativa legal de obligado cumplimiento.<br>
                                El Usuario asume su responsabilidad de un uso correcto del Sitio Web, que se extiende a:<br>
                                - Hacer uso del Sitio Web únicamente para realizar consultas y compras o adquisiciones legalmente válidas.<br>
                                - No realizar ninguna compra falsa o fraudulenta. Si razonablemente se pudiera considerar que se ha hecho una compra de esta índole, podría ser anulada y se informaría a las autoridades pertinentes.<br>
                                - Facilitar datos de contacto veraces y lícitos, como dirección de correo electrónico, dirección postal y/u otros datos requeridos.<br>
                                El Usuario declara ser mayor de 18 años y tener capacidad legal para celebrar contratos a través de este Sitio Web.<br>
                                El Sitio Web está dirigido principalmente a Usuarios residentes en España. El titular no asegura que el Sitio Web cumpla con legislaciones de otros países, ni garantiza envíos o prestación de servicios fuera de España.<br>
                                El Usuario podrá formalizar, a su elección, el contrato de compraventa en cualquiera de los idiomas en los que las presentes Condiciones estén disponibles en el Sitio Web.
                            </p>
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">3. Proceso de Compra o Adquisición</h3>
                            <p>
                                Los Usuarios debidamente registrados pueden comprar en el Sitio Web por los medios y formas establecidos, siguiendo el procedimiento de compra online, durante el cual podrán seleccionar y añadir productos y/o servicios al carrito y, finalmente, confirmar la compra.<br>
                                El Usuario deberá rellenar y/o comprobar la información solicitada en cada paso, pudiendo modificar los datos antes de realizar el pago.<br>
                                Tras finalizar el proceso, el Usuario recibirá un correo electrónico confirmando la recepción del pedido y, en su caso, la confirmación de envío.<br>
                                El Usuario consiente que el Sitio Web genere una factura electrónica, que se enviará por correo electrónico. Puede solicitar una copia en papel si lo desea.<br>
                                El Usuario reconoce estar al corriente, en el momento de la compra, de las condiciones particulares de venta aplicables a cada producto o servicio, como nombre, precio, componentes, peso, cantidad, color, detalles, modo y coste de las prestaciones.<br>
                                Las comunicaciones, órdenes de compra y pagos podrán ser archivados y conservados en los registros informatizados del titular, respetando las condiciones de seguridad y la normativa vigente, especialmente el RGPD y la Ley Orgánica 3/2018.
                            </p>
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">4. Disponibilidad</h3>
                            <p>
                                Todos los pedidos de compra recibidos a través del Sitio Web están sujetos a la disponibilidad de los productos y/o a que ninguna circunstancia o causa de fuerza mayor afecte al suministro o prestación de los servicios.<br>
                                Si se produjeran dificultades en el suministro o no quedaran productos en stock, el titular se compromete a contactar al Usuario y reembolsar cualquier cantidad abonada. Esto será igualmente aplicable si la prestación de un servicio deviniera irrealizable.
                            </p>
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">5. Precios y Pago</h3>
                            <p>
                                Los precios exhibidos en el Sitio Web son finales, en Euros (€) e incluyen los impuestos, salvo que por exigencia legal se indique lo contrario.<br>
                                Los gastos de envío están incluidos en los precios finales, salvo indicación contraria. No se añadirán costes adicionales de forma automática, solo aquellos seleccionados voluntariamente por el Usuario.<br>
                                Los precios pueden cambiar en cualquier momento, pero no afectarán a los pedidos ya confirmados.<br>
                                Los medios de pago aceptados serán: Tarjeta de crédito o débito.<br>
                                Las tarjetas de crédito estarán sujetas a comprobaciones y autorizaciones por parte de la entidad bancaria emisora. Si no se autoriza el pago, el titular no será responsable por retrasos o falta de entrega.<br>
                                Al recibir la orden de compra, se podrá realizar una pre-autorización en la tarjeta para asegurar fondos suficientes. El cargo se hará en el momento de la confirmación de envío.<br>
                                Al confirmar la compra, el Usuario declara que el método de pago utilizado es suyo.
                            </p>
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">6. Entrega</h3>
                            <p>
                                Las entregas se efectuarán en España (Península y Baleares).<br>
                                Salvo circunstancias imprevistas o extraordinarias, el pedido será entregado en el plazo señalado en el Sitio Web según el método de envío seleccionado y, en todo caso, en un máximo de 30 días naturales desde la confirmación del pedido.<br>
                                Si el titular no pudiera cumplir con la fecha de entrega, contactará al Usuario para acordar una nueva fecha o anular el pedido con reembolso total.<br>
                                Si resulta imposible efectuar la entrega por ausencia del Usuario, el pedido podría ser devuelto al almacén y el transportista dejaría un aviso.<br>
                                Si el Usuario no va a estar en el lugar de entrega, debe contactar para convenir otra fecha.<br>
                                Si transcurren 30 días desde que el pedido esté disponible para su entrega y no ha sido entregado por causa no imputable al titular, se entenderá que el Usuario desea desistir del contrato y se reembolsarán los pagos recibidos, salvo gastos adicionales por elección de modalidad de entrega distinta.<br>
                                La entrega se considerará realizada cuando el Usuario o un tercero adquiera la posesión material de los productos, acreditado mediante la firma de la recepción.<br>
                                Los riesgos de los productos serán a cargo del Usuario desde la entrega. El Usuario adquiere la propiedad cuando el titular recibe el pago completo.<br>
                                Los pedidos se entenderán localizados en territorio de aplicación del IVA español si la dirección de entrega está en España (salvo Canarias, Ceuta y Melilla).
                            </p>
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">7. Medios Técnicos para Corregir Errores</h3>
                            <p>
                                Si el Usuario detecta un error al introducir datos necesarios para procesar su compra, podrá modificar los mismos contactando con el titular a través de los espacios de contacto habilitados en el Sitio Web o mediante su espacio personal.<br>
                                Antes de confirmar la compra, el Usuario puede acceder al carrito y modificar los datos.<br>
                                Se recomienda consultar el Aviso Legal y la Política de Privacidad para más información sobre el derecho de rectificación según el RGPD y la Ley Orgánica 3/2018.
                            </p>
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">8. Devoluciones</h3>
                            <p>
                                El Usuario tiene derecho a desistir de la compra en un plazo de 14 días naturales sin necesidad de justificación.<br>
                                Para ejercer este derecho, debe comunicarlo claramente al titular.<br>
                                El reembolso se realizará utilizando el mismo método de pago empleado en la compra.<br>
                                Existen excepciones al derecho de desistimiento según la normativa vigente.
                            </p>
                            <h5 class="mt-4 fw-bold">Política de Cancelación</h5>
                            <p>
                                El Usuario podrá cancelar un pedido siempre que éste no haya sido procesado o enviado. Para solicitar la cancelación, debe contactar lo antes posible con el titular a través de los medios de contacto facilitados en el Sitio Web.<br>
                                Si el pedido ya ha sido procesado o enviado, el Usuario deberá esperar a recibirlo y, en su caso, ejercer el derecho de desistimiento conforme a la normativa vigente.<br>
                                En caso de cancelación antes del envío, se reembolsará el importe íntegro utilizando el mismo método de pago empleado en la compra.
                            </p>
                            <h5 class="mt-4 fw-bold">Derecho de Desistimiento</h5>
                            <p>
                                El Usuario, en tanto que consumidor y usuario, realiza una compra en el Sitio Web y, por tanto le asiste el derecho a desistir de dicha compra en un plazo de 14 días naturales sin necesidad de justificación.<br>
                                Este plazo de desistimiento expirará a los 14 días naturales del día que el Usuario o un tercero autorizado por éste, distinto del transportista, adquirió la posesión material de los bienes adquiridos en el Sitio Web de tienda online o en caso de que los bienes que componen su pedido se entreguen por separado, a los 14 días naturales del día que el Usuario o un tercero autorizado por éste, distinto del transportista, adquirió la posesión material del último de esos bienes que componían un mismo pedido de compra, o en el caso de tratarse de un contrato de servicios, a los 14 días naturales desde el día de la celebración del contrato.<br>
                                Para ejercer este derecho de desistimiento, el Usuario deberá notificar su decisión a tienda online. Podrá hacerlo, en su caso, a través de los espacios de contacto habilitados en el Sitio Web.<br>
                                El Usuario, independientemente del medio que elija para comunicar su decisión, debe expresar de forma clara e inequívoca que es su intención desistir del contrato de compra. En todo caso, el Usuario podrá utilizar el modelo de formulario de desistimiento que tienda online pone a su disposición como parte anexada a estas Condiciones, sin embargo, su uso no es obligatorio.<br>
                                Para cumplir el plazo de desistimiento, basta con que la comunicación que expresa inequívocamente la decisión de desistir sea enviada antes de que venza el plazo correspondiente.<br>
                                En caso de desistimiento, tienda online reembolsará al Usuario todos los pagos recibidos, incluidos los gastos de envío (con la excepción de los gastos adicionales elegidos por el Usuario para una modalidad de envío diferente a la modalidad menos costosa ofrecida en el Sitio Web) sin ninguna demora indebida y, en todo caso, a más tardar en 14 días naturales a partir de la fecha en la que tienda online es informado de la decisión de desistir por el Usuario.<br>
                                tienda online reembolsará al Usuario utilizando el mismo método de pago que empleó este para realizar la transacción inicial de compra. Este reembolso no generará ningún coste adicional al Usuario. No obstante, tienda online podría retener dicho reembolso hasta haber recibido los productos o artículos de la compra, o hasta que el Usuario presente una prueba de la devolución de los mismos, según qué condición se cumpla primero.<br>
                                El Usuario puede devolver o enviar los productos a tienda online en:<br>
                                Y deberá hacerlo sin ninguna demora indebida y, en cualquier caso, a más tardar en el plazo de 14 días naturales a partir de la fecha en que tienda online fue informado de la decisión de desistimiento.<br>
                                El Usuario reconoce conocer que deberá asumir el coste directo de devolución (transporte, entrega) de los bienes, si se incurriera en alguno. Además, será responsable de la disminución de valor de los productos resultante de una manipulación distinta a la necesaria para establecer la naturaleza, las características y el funcionamiento de los bienes.<br>
                                El Usuario reconoce saber que existen excepciones al derecho de desistimiento, tal y como se recoge en el artículo 103 del Real Decreto Legislativo 1/2007, de 16 de noviembre, por el que se aprueba el texto refundido de la Ley General para la Defensa de los Consumidores y Usuarios y otras leyes complementarias. De forma enunciativa, y no exhaustiva, este sería el caso de: productos personalizados; productos que puedan deteriorarse o caducar con rapidez; CDs/DVD de música o video sin su envoltorio, tal y como se precinta en fábrica; productos que por razones de higiene o de la salud van precintados y han sido desprecintados tras la entrega; suministro de contenido digital sin soporte físico.<br>
                                En este mismo sentido se rige la prestación de un servicio que el Usuario pudiera contratar en este Sitio Web, pues esta misma Ley establece que no asistirá el Derecho de desistimiento a los Usuarios cuando la prestación del servicio ha sido completamente ejecutada, o cuando haya comenzado, con el consentimiento expreso del consumidor y usuario y con el reconocimiento por su parte de que es consciente de que, una vez que el contrato haya sido completamente ejecutado por tienda online, habrá perdido su derecho de desistimiento.<br>
                                En todo caso, no se hará ningún reembolso si el producto ha sido usado más allá de la mera apertura del mismo, de productos que no estén en las mismas condiciones en las que se entregaron o que hayan sufrido algún daño tras la entrega.<br>
                                Asimismo, se debe devolver los productos usando o incluyendo todos sus envoltorios originales, las instrucciones y demás documentos que en su caso los acompañen, además de una copia de la factura de compra.<br>
                                En el siguiente enlace puede descargarse el Modelo de formulario de desistimiento:
                            </p>
                            <h5 class="mt-4 fw-bold">Devolución de productos defectuosos o error en el envío</h5>
                            <p>
                                Se trata de todos aquellos casos en los que el Usuario considera que, en el momento de la entrega, el producto no se ajusta a lo estipulado en el contrato o pedido de compra, y que, por tanto, deberá ponerse en contacto con tienda online inmediatamente y hacerle saber la disconformidad existente (defecto/error) por los mismos medios o utilizando los datos de contacto que se facilitan en el apartado anterior (Derecho de Desistimiento).<br>
                                El Usuario será entonces informado sobre cómo proceder a la devolución de los productos, y estos, una vez devueltos, serán examinados y se informará al Usuario, dentro de un plazo razonable, si procede el reembolso o, en su caso, la sustitución del mismo.<br>
                                El reembolso o la sustitución del producto se efectuará lo antes posible y, en cualquier caso, dentro de los 14 días siguientes a la fecha en la que le enviemos un correo electrónico confirmando que procede el reembolso o la sustitución del artículo no conforme.<br>
                                El importe abonado por aquellos productos que sean devueltos a causa de algún defecto, cuando realmente exista, será reembolsado íntegramente, incluidos los gastos de entrega y los costes en que hubiera podido incurrir el Usuario para realizar la devolución. El reembolso se efectuará por el mismo medio de pago que el Usuario utilizó para pagar la compra.<br>
                                En todo caso, se estará siempre a los derechos reconocidos en la legislación vigente en cada momento para el Usuario, en tanto que consumidor y usuario.
                            </p>
                            <h5 class="mt-4 fw-bold">Garantías</h5>
                            <p>
                                El Usuario, en tanto que consumidor y usuario, goza de garantías sobre los productos que pueda adquirir a través de este Sitio Web, en los términos legalmente establecidos para cada tipo de producto, respondiendo tienda online, por tanto, por la falta de conformidad de los mismos que se manifieste en un plazo de tres años desde la entrega del producto.<br>
                                En este sentido, se entiende que los productos son conformes con el contrato siempre que: se ajusten a la descripción realizada por tienda online y posean las cualidades presentadas en la misma; sean aptos para los usos a que ordinariamente se destinan los productos del mismo tipo; y presenten la calidad y prestaciones habituales de un producto del mismo tipo y que sean fundamentalmente esperables del mismo. Cuando esto no sea así respecto de los productos entregados al Usuario, éste deberá proceder tal y como se indica en el apartado Devolución de productos defectuosos o error en el envío. No obstante, algunos de los productos que se comercializan en el Sitio Web, podrían presentar características no homogéneas siempre y cuando éstas deriven del tipo de material con el que se han fabricado, y que por ende formarán parte de la apariencia individual del producto, y no serán un defecto.<br>
                                Por otra parte, podría llegar a darse el caso que el Usuario adquiere en el Sitio Web un producto de una marca o de fabricación por un tercero. En este caso, y considerando el Usuario que se trata de un producto defectuoso, éste también tiene la posibilidad de ponerse en contacto con la marca o fabricante responsable del producto para averiguar cómo ejercer su derecho de garantía legal directamente frente a los mismos durante los tres años siguientes a la entrega de dichos productos. Para ello, el Usuario debe haber conservado toda la información en relación con la garantía de los productos.
                            </p>
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">9. Exoneración de Responsabilidad</h3>
                            <p>
                                Salvo disposición legal en sentido contrario, el titular no aceptará responsabilidad por:<br>
                                - Pérdidas no atribuibles a incumplimiento propio.<br>
                                - Pérdidas empresariales (incluyendo lucro cesante, ingresos, contratos, ahorros previstos, datos, fondo de comercio o gastos innecesarios incurridos).<br>
                                - Otras pérdidas indirectas no razonablemente previsibles en el momento de la formalización del contrato.<br>
                                El titular aplica todas las medidas para proporcionar una visualización fiel del producto, pero no se responsabiliza por mínimas diferencias debidas a la resolución de pantalla, navegador u otros factores.<br>
                                No se responsabiliza por perjuicios derivados de mal funcionamiento del transporte, especialmente por causas ajenas como huelgas, retenciones, etc.<br>
                                No será responsable por fallos técnicos, falta de disponibilidad del Sitio Web por mantenimiento u otras causas ajenas.<br>
                                No se hará responsable del mal uso o desgaste de los productos por parte del Usuario, ni de devoluciones erróneas.<br>
                                En general, no será responsable por incumplimientos debidos a causas fuera de su control razonable (fuerza mayor), incluyendo huelgas, conflictos civiles, desastres naturales, imposibilidad de uso de transportes o telecomunicaciones, o actos de autoridades públicas.<br>
                                Las obligaciones quedarán suspendidas durante el periodo de fuerza mayor, ampliándose el plazo para cumplirlas por el tiempo que dure la causa.
                            </p>
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">10. Comunicaciones y Notificaciones</h3>
                            <p>
                                El Usuario acepta que la mayor parte de las comunicaciones sean electrónicas (correo electrónico o avisos en el Sitio Web).<br>
                                A efectos contractuales, el Usuario consiente el uso de este medio y reconoce que cumple con los requisitos legales de comunicación por escrito.<br>
                                El Usuario puede enviar notificaciones y comunicarse con el titular a través de los datos de contacto facilitados y los espacios de contacto del Sitio Web.<br>
                                Salvo estipulación contraria, el titular podrá contactar al Usuario en su correo electrónico o dirección postal facilitada.
                            </p>
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">11. Renuncia</h3>
                            <p>
                                Ninguna renuncia a un derecho o acción legal supondrá una renuncia a otros derechos o acciones derivados de un contrato o de las Condiciones, salvo que se establezca expresamente por escrito.<br>
                                La falta de requerimiento del cumplimiento estricto de alguna obligación no supondrá una renuncia a exigirlo posteriormente.
                            </p>
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">12. Nulidad</h3>
                            <p>
                                Si alguna de las presentes Condiciones fuese declarada nula y sin efecto por resolución firme dictada por autoridad competente, el resto de las cláusulas permanecerán en vigor, sin que queden afectadas por dicha declaración de nulidad.
                            </p>
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">13. Acuerdo Completo</h3>
                            <p>
                                Estas Condiciones y todo documento al que se haga referencia expresa constituyen el acuerdo íntegro entre el Usuario y el titular en relación con la compraventa y sustituyen a cualquier otro pacto anterior.<br>
                                El Usuario y el titular reconocen haber consentido la celebración del contrato sin haber confiado en ninguna declaración o promesa hecha por la otra parte, salvo lo expresamente mencionado en estas Condiciones.
                            </p>
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">14. Protección de Datos</h3>
                            <p>
                                Los datos personales facilitados serán tratados conforme a la Política de Privacidad del Sitio Web y la normativa vigente (RGPD y Ley Orgánica 3/2018).<br>
                                Al usar el Sitio Web, el Usuario consiente dicho tratamiento y declara que los datos facilitados son veraces.
                            </p>
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">15. Legislación Aplicable y Jurisdicción</h3>
                            <p>
                                El acceso, navegación y uso del Sitio Web y los contratos de compra se regirán por la legislación española.<br>
                                Cualquier controversia será sometida a la jurisdicción no exclusiva de los juzgados y tribunales españoles.
                            </p>
                        </div>

                        <div class="mb-4">
                            <h3 class="mb-3 text-primary fw-bold">16. Quejas y Reclamaciones</h3>
                            <p>
                                El Usuario puede enviar quejas, reclamaciones o comentarios a través de los datos de contacto facilitados.<br>
                                El titular dispone de hojas oficiales de reclamación a disposición de los consumidores y usuarios.<br>
                                Para resolución extrajudicial de litigios: <a href="https://ec.europa.eu/consumers/odr/" target="_blank">https://ec.europa.eu/consumers/odr/</a>
                            </p>
                        </div>
                    </div> <!-- end row -->
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-12-->
    </div> <!-- end row-->
</div>
@endsection