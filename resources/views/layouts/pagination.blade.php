<style>
    .page-item{
        list-style-type:none;
        position: relative;
        display: flex;
        margin-left: -1px !important;
        color: #007bff;
        background-color: #fff;
        border: none;
        transform: skew(-20deg);
    }
    .pagination {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        padding-left: 0;
        margin: 0 !important;
        list-style: none;
        gap: 10px;
        border-radius: 0.25rem; }

    .page-item span {
        line-height: 1.25;
        padding: 0.75rem 1rem;
        transform: skew(20deg);
    }
    .page-item a {
        line-height: 1.25;
        padding: 0.75rem 1rem;
        transform: skew(20deg);
    }
    .page-item:hover:not(.page-item.disabled):not(.page-item.active) {
        z-index: 2;
        color: #0056b3;
        text-decoration: none;
        background-color: #e9ecef;
        border-color: #dee2e6; }
    .page-item:focus {
        z-index: 2;
        outline: 0;
        -webkit-box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); }

    .page-item:first-child .page-link {
        margin-left: 0;
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem; }

    .page-item:last-child .page-link {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem; }

    .page-item.active {
        z-index: 1;
        color: #fff;
        background-color: #007bff;
        border-color: #007bff; }

    .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        cursor: pointer;
        border-color: #dee2e6; }

    .pagination-lg .page-link {
        padding: 0.75rem 1.5rem;
        font-size: 1.25rem;
        line-height: 1.5; }

    .pagination-lg .page-item:first-child .page-link {
        border-top-left-radius: 0.3rem;
        border-bottom-left-radius: 0.3rem; }

    .pagination-lg .page-item:last-child .page-link {
        border-top-right-radius: 0.3rem;
        border-bottom-right-radius: 0.3rem; }

    .pagination-sm .page-link {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5; }

    .pagination-sm .page-item:first-child .page-link {
        border-top-left-radius: 0.2rem;
        border-bottom-left-radius: 0.2rem; }

    .pagination-sm .page-item:last-child .page-link {
        border-top-right-radius: 0.2rem;
        border-bottom-right-radius: 0.2rem; }
</style>
