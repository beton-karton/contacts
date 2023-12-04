<div>
    <script>
        window.addEventListener('show_contactModal', event => {
            $('#contactModal').modal('show');
        });
        window.addEventListener('hide_contactModal', event => {
            $('#contactModal').modal('hide');
        });
        window.addEventListener('show_confirmModal', event => {
            $('#confirmModal').modal('show');
        });
        window.addEventListener('hide_confirmModal', event => {
            $('#confirmModal').modal('hide');
        });
    </script>

    <div class="row">
        <div class="col-sm-6">

            <div class="row mb-4 d-flex align-items-center">
                <div class="col-sm-8">
                    <div class="input-group">
                        <input
                            wire:model="searchString"
                            wire:keydown.enter="makeSearch"
                            wire:keydown.escape="clearSearch"
                            type="text" class="form-control" aria-describedby="search-button">
                        <button
                            wire:click="makeSearch"
                            class="btn btn-outline-secondary"
                            type="button"
                            id="search-button">
                            <i class="bi bi-search"></i>
                        </button>
                        <button wire:click="clearSearch" class="btn btn-outline-secondary" type="button" id="clear-search-button"><i class="bi bi-x-lg"></i></button>
                    </div>
                </div>
                <div class="col-sm-4 text-end text-primary">
                    <a wire:click="addContact">
                        <i class="bi bi-plus-circle"></i>
                        Добавить контакт
                    </a>
                </div>
            </div>

            @foreach ($contacts as $letter)
                <div class="letter-list">{{ $letter->firstLetter }}</div>
                    <ul class="list-group list-group-flush">
                        @foreach ($letter->contacts as $el)
                            <li class="list-group-item">
                                @if($el->id == $contactId)
                                <a wire:click="selectContact({{ $el->id }})" class="mb-0 text-primary">{{ $el->firstName . ' ' . $el->lastName }}</a>
                                @else
                                <a wire:click="selectContact({{ $el->id }})">{{ $el->firstName . ' ' . $el->lastName }}</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
            @endforeach

        </div>
        <div class="col-sm-6">
            @if ($contactId)
                <div class="p-3 border-start">
                    <h6 class="mb-3 fw-bold">Сведения о контакте</h6>
                    <ul class="list-group list-group-flush mt-3 mb-3">
                        <li class="list-group-item">Имя: {{ $contact->firstName }}</li>
                        <li class="list-group-item">Фамилия: {{ $contact->lastName }}</li>
                        <li class="list-group-item">Телефон: {{ $contact->phone }}</li>
                        <li class="list-group-item">E-mail: {{ $contact->email }}</li>
                    </ul>
                    <a wire:click="editContact" class="text-success me-3"><i
                            class="bi bi-pencil-square me-1"></i>Редактировать</a>
                    <a wire:click="delContact" class="text-danger"><i class="bi bi-trash me-1"></i>Удалить</a>
                </div>
            @endif
        </div>
    </div>

    <!-- ContactModal -->
    <div wire:ignore.self class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center">
                    <h6 class="mb-0">Добавление контакта</h6>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input wire:model="firstName" type="text" class="form-control" id="firstName">
                        <label for="firstName">Имя</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input wire:model="lastName" type="text" class="form-control" id="lastName">
                        <label for="lastName">Фамилия</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input wire:model="phone" type="text" class="form-control" id="phone">
                        <label for="phone">Телефон</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input wire:model="email" type="email" class="form-control" id="email">
                        <label for="email">E-mail</label>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="button" wire:click.prevent="saveContact" class="btn btn-primary"
                        data-bs-dismiss="modal">
                        Сохранить
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ConfirmModal -->
    <div wire:ignore.self class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header d-flex justify-content-center">
                    <h6 class="mb-0">Удаление контакта</h6>
                </div>

                <div class="modal-body  d-flex justify-content-center">
                    <label>Вы уверены, что хотите удалить контакт?</label>
                </div>

                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="button" wire:click.prevent="deleteContact" class="btn btn-primary"
                        data-bs-dismiss="modal">
                        Удалить
                    </button>
                </div>

            </div>
        </div>
    </div>

</div>
