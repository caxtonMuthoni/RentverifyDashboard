<style>
    .img-container {
        height: auto;
        max-height: 400px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 20px 0;
        border-radius: 10px;
        overflow: hidden;
        display: block;
    }

    .img {
        height: auto;
        max-height: 400px;
        width: 100%;
        object-fit: contain;
        object-position: center;
        border-radius: 10px;
        overflow: hidden;
    }
</style>
<div class="img-container">
    <strong>Back National ID Image</strong>
    <img src="{{ $tenant->idbackimages[0]->url }}" alt="" class="img">
</div>