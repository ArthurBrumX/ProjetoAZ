<?php
    
    USE \App\Entity\Feedback;
    
    $obFeedbacksReprovados = Feedback::getFeedbacks('id_status_feedback = 3', 'id_feedback', '');
    
    
    if(isset($_POST['IdFeedbackCard'])){
        $postIdFeedback = $_POST['IdFeedbackCard'];
        $currentIdPost;

?>

    <!-- BLOCO DOS MODAIS -->
    <div class="joinha">
        <div id="modal-like" class="modal-feed">
            <div class="modal-dialog" style="color: red"><strong>
                <br>
                <?php 
                        foreach($obFeedbacksReprovados as $keys => $values) {
                            if($values->id_feedback) {
                                $currentIdPost = $values->id_feedback;        
                            }
                                            
                            if($currentIdPost == $postIdFeedback){
                ?>
                <div class="modal-content">
                    <header class="container-feed-like" id="header-cont-feed-like">
                        <a href="#" class="closebtn-feed"><sup>x</sup></a>
                        <h2>Aprovadíssimo!!!</h2>
                    </header>                    
                    <div class="container-feed-like" id="cont-feed-like">
                        <a href="#positivo"><img src="IMG/cards/Boneco Positivo.png" alt="Carregando..." id="positivo"></a>
                        <p id="aviso-like">Thank you!!!</p>
                        
                        <!-- Apenas para teste - apagar depois -->
                        <h3 style="color: red"><?= 'id_feedback: ' . $currentIdPost; ?></h3>                        
                    </div>                        
                        <footer class="container-feed-like" id="footer-cont-feed-like">
                            <div class="aprova-modal">
                                <!-- <form action="#aprovarphp" id="justify-form"> -->
                                <form method= "POST" id="justify-form">
                                    <button type="submit" value="APROVADO"><STROng> A P R O V A D O 
                                        <input type="hidden" value="APROVADO" id="btn-aprovar" name="feedAprovado">
                                        <input type="hidden" value="<?= $currentIdPost?>" id="btn-aprovar" name="modalCurrentIdPost">
                                    </STROng></button>                                                
                                </form>
                            </div>
                        </footer>
                </div>
                <br>
                        <?php } ?> 
                        <?php } ?>
            </strong></div>
        </div>




        <div id="modal-dislike" class="modal-feed">
            <div class="modal-dialog" style="color: red"><strong>
                <br>
                <?php 
                        foreach($obFeedbacksReprovados as $keys => $values) {
                            if($values->id_feedback) {
                                $currentIdPost = $values->id_feedback;        
                            }                                            
                            if($currentIdPost == $postIdFeedback){
                ?>
                <div class="modal-content">
                    <header class="container-feed-dislike" id="header-cont-feed-dislike">
                        <a href="#" class="closebtn-feed"><sup>x</sup></a>
                        <h2>Refletir!!!</h2>
                    </header>
                    <div class="container-feed-dislike" id="cont-feed-dislike">
                        <a href="#negativo"><img src="IMG/cards/Boneco Negativo.png" alt="Carregando..." id="negativo"></a>

                        <!-- Apenas para teste - apagar depois -->
                        <h3 style="color: red"><?= 'id_feedback: ' . $currentIdPost; ?></h3>                        
                        <p id="aviso-dislike">Por favor digite a sua resposta</p>
                    </div>
                    <footer class="container-feed-dislike" id="footer-cont-feed-dislike">
                        <div class="justify-modal">
                            <form method= "POST" id="justify-form1">
                                Justificativa: <textarea id="mensagem" name="mensagem" rows="6" cols="35" placeholder="Digite aqui a sua justificativa."></textarea>
                                <button type="submit" value="REPROVADO" id="btn-enviar"><STROng> ENVIAR 
                                    <input type="hidden" value="REPROVADO" id="btn-reprovar" name="feedReprovado">
                                    <input type="hidden" value="<?= $currentIdPost?>" id="btn-reprovar" name="modalCurrentIdPost">
                                </STROng></button>
                            </form>
                        </div>                            
                    </footer>
                </div>
                        <?php } ?> 
                        <?php } ?>
            </strong></div>
        </div>
    </div>
    <?php } ?>  