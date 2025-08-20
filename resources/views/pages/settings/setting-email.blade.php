@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">

    <ul class="nav nav-tabs mb-3" id="emailTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="sent-tab" data-bs-toggle="tab" data-bs-target="#sent" type="button" role="tab" aria-controls="sent" aria-selected="true">
                Bandeja de salida
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="inbox-tab" data-bs-toggle="tab" data-bs-target="#inbox" type="button" role="tab" aria-controls="inbox" aria-selected="false">
                Bandeja de entrada
            </button>
        </li>
    </ul>

    <div class="tab-content" id="emailTabsContent">
        <div class="tab-pane fade show active" id="sent" role="tabpanel" aria-labelledby="sent-tab">
            <div>
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-send-fill fs-3 text-primary me-2"></i>
                    <h2 class="mb-0">Bandeja de salida de mensajes</h2>
                </div>
                <table id="emails-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Origen</th>
                            <th>Destinatario</th>
                            <th>Fecha/Hora de envío</th>
                            <th>Tamaño (KB)</th>
                            <th>Errores</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emailsSent as $email)
                        <tr>
                            <td>{{ $email->id }}</td>
                            <td>{{ $email->from }}</td>
                            <td>{{ $email->to }}</td>
                            <td>{{ $email->date }}</td>
                            <td>{{ $email->size_kb }}</td>
                            <td>
                                @if($email->has_error)
                                <span class="text-danger">Error</span>
                                @else
                                <span class="text-success">Sin Errores</span>
                                @endif
                            </td>
                            <td>
                                @if($email->has_error)
                                <button
                                    type="button"
                                    class="btn btn-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewEmailModal"
                                    data-email-id="{{ $email->id }}"
                                    data-email-from="{{ $email->from }}"
                                    data-email-to="{{ $email->to }}"
                                    data-email-date="{{ $email->date }}"
                                    data-email-subject="{{ $email->subject ?? '(Sin asunto)' }}"
                                    data-email-body="{{ json_encode($email->body_html ?? $email->body_text) }}">
                                    Ver Error de Email
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="inbox" role="tabpanel" aria-labelledby="inbox-tab">
            <div>
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-inbox-fill fs-3 text-primary me-2"></i>
                    <h2 class="mb-0">Bandeja de entrada de mensajes</h2>
                </div>
                <table id="emails-inbox-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Remitente</th>
                            <th>Destinatario</th>
                            <th>Fecha/Hora de recepción</th>
                            <th>Tamaño (KB)</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emailsInbox as $email)
                        <tr>
                            <td>{{ $email->id }}</td>
                            <td>{{ $email->from }}</td>
                            <td>{{ $email->to }}</td>
                            <td>{{ $email->date }}</td>
                            <td>{{ $email->size_kb }}</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-info btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewEmailModal"
                                    data-email-id="{{ $email->id }}"
                                    data-email-from="{{ $email->from }}"
                                    data-email-to="{{ $email->to }}"
                                    data-email-date="{{ $email->date }}"
                                    data-email-subject="{{ $email->subject ?? '(Sin asunto)' }}"
                                    data-email-body="{{ json_encode($email->body_html ?? $email->body_text) }}">
                                    Ver Email
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal único -->
    <div class="modal fade" id="viewEmailModal" tabindex="-1" aria-labelledby="viewEmailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewEmailModalLabel">Email</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <strong>De:</strong> <span id="modal-email-from"></span><br>
                    <strong>Para:</strong> <span id="modal-email-to"></span><br>
                    <strong>Fecha:</strong> <span id="modal-email-date"></span><br>
                    <strong>Asunto:</strong> <span id="modal-email-subject"></span><br>
                    <hr>
                    <div id="modal-email-body"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#emails-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            }
        });
        $('#emails-inbox-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            }
        });

        $('#viewEmailModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            $('#viewEmailModalLabel').text('Email #' + button.data('email-id'));
            $('#modal-email-from').text(button.data('email-from'));
            $('#modal-email-to').text(button.data('email-to'));
            $('#modal-email-date').text(button.data('email-date'));
            $('#modal-email-subject').text(button.data('email-subject'));

            var body = button.data('email-body');
            try {
                body = JSON.parse(body);
            } catch (e) {}
            $('#modal-email-body').html(body);
        });
    });
</script>
@endpush