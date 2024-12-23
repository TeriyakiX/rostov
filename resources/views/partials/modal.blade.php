<div id="successModal" style="display: none;">
    <div class="modal-content">

        <svg class="modal-close" onClick="closeModal()">
            <use xlink:href="{{ asset('img/sprites/sprite-mono.svg#close') }}"></use>
        </svg>

        <svg class="modal-status">
            <use xlink:href="{{ asset('img/icons/modal-access.svg#access') }}"></use>
        </svg>
        <h3>Спасибо!</h3>
        <p>Ваше обращение на консультацию принято</p>
        <span>Наш менеджер свяжется с вами. Среднее время ожидания ответа: 20–30 минут в рабочее время.</span>
        <button class="btn btn-primary" onClick="closeModal()">Спасибо, жду звонка</button>
    </div>
</div>

<script>
    function closeModal() {
        document.getElementById('successModal').style.display = 'none';
    }
</script>
