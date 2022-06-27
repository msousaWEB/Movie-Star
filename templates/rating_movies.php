
<div class="col-md-12" id="review-form-container">
    <h4>Envie a sua avaliação!</h4>
    <p class="page-description">Deixe a sua nota e impressões sobre o filme!</p>
    <form  id="review-form" action="<?=$app?>review_process.php" method="POST">
        <input type="hidden" name="type" value="create">
        <input type="hidden" name="movies_id" value="<?= $movie->id ?>">
        <div class="form-group">
            <label for="rating">Nota do filme:</label>
            <select name="rating" id="rating" class="form-control">
                <option value="5">5</option>
                <option value="4">4</option>
                <option value="3">3</option>
                <option value="2">2</option>
                <option value="1">1</option>
            </select>
        </div>
        <div class="form-group">
            <label for="review">Seu comentário:</label>
            <textarea class="form-control" name="review" id="review" rows="3" placeholder="Qual sua opinião sobre este filme?"></textarea>
        </div>
        <input type="submit" class="btn card-btn" value="Enviar">
    </form>
</div>