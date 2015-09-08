<style>
    .form-desk, .form-mob{
        display:none;
    }
</style>
<!-- reservation desktop left-->
<div class="bloc1 mobbloc1">
    <div class = 'formulaire content form-desk'>
        <div class="left-bloc">
            <div class="contenu" id="reservation-left">
                <div class="titre">
                    <h3>
                        Choisissez votre lieu de prise en charge
                    </h3>
                </div>
                <div class="selecteur">
                    <input type="radio" name="lieu" value="0" id="aeroport" checked="checked" />
                    <label for="aeroport"><span></span>AEROPORTS</label>
                    <input type="radio" name="lieu" value="1" id="gares" />
                    <label for="gares"><span></span>GARES</label>
                    <input type="radio" name="lieu" value="2" id="ville" />
                    <label for="ville"><span></span>VILLE</label>
                </div>
                <div class="separateur"></div>
                <input type="text" readonly='true' name="date_aller" id="date_aller" placeholder="Date aller" class="date-aller">
                <label for="date_aller" id="label-date-aller">à HH:MM</label>
                <img class="ui-datepicker-trigger" src="images/date.png" alt="..." title="...">
                <input type="text" name="vol_aller" id="vol_aller" placeholder="N° vol aller" class="vol-aller">
                <img class="vol-aller-picto vol-aller-src" src="images/vol_aller.png" alt="..." title="...">
                <select name="terminal_aller" id="terminal_aller" class="vol-aller">
                    <?php $terms=DB::select(["*"], SPOT_TABLE);foreach($terms as $term) echo "<option value=\"{$term['id']}\">{$term['nom']}</option>"; ?>
                    <option class="train" value="4">toto</option>
                    <option class="train" value="5">salut</option>
                </select>
                <img class="vol-aller-picto vol-terminal-src" src="images/compagnie.png" alt="..." title="...">
                <div style="width: 100%; height: 30px;"></div>
                <input type="text" readonly='true' name="date_retour" id="date_retour" placeholder="Date retour" class="date-aller">
                <label for="date_retour" id="label-date-retour">à HH:MM</label>
                <img class="ui-datepicker-trigger" src="images/date.png" alt="..." title="...">
                <input type="text" name="vol_retour" id="vol_retour" placeholder="N° vol retour" class="vol-aller">
                <img class="vol-aller-picto vol-retour-src" src="images/vol_retour.png" alt="..." title="...">
                <select name="terminal_retour" id="terminal_retour" class="vol-aller">
                    <?php $terms=DB::select(["*"], SPOT_TABLE);foreach($terms as $term) echo "<option value=\"{$term['id']}\">{$term['nom']}</option>"; ?>
                </select>
                <img class="vol-aller-picto vol-terminal-src" src="images/compagnie.png" alt="..." title="...">
                <p>Je ne connais pas mes numéros de vols</p>
                <div class="bouton-action" id="commander">Commander un edgar</div>
            </div>
        </div>
<!-- reservation desktop right -->
        <div class="right-bloc">
            <div class="contenu" id="reservation-right">
                <div class="erreur-resa">
                    <div class="titre">
                        <h3>
                            Problème dans votre réservation
                        </h3>
                    </div>
                    <ul>
                        <li>Tous les champs sont obligatoires</li>
                        <li>Les numéros de vols doivent être choisis dans la liste</li>
                        <li>La date de retour ne doit pas être inférieure à la date de départ.</li>
                    </ul>
                </div>
                <div id="datepicker_aller" class="aller-datetime-aeroport" style="display: none;">
                    <div class="titre">
                        <h3>
                            Choisissez la date de votre vol de départ
                        </h3>
                    </div>
                </div>
                <div class="time-picker aller-datetime-aeroport">
                    <div class="titre">
                        <h3>
                            Heure de prise en charge de votre véhicule
                        </h3>
                    </div>
                    <div class="time-picker-box">
                        <div class="time-picker-up noselect" id="hour-up"></div>
                        <div class="time-picker-val"><input type="text" value="HH" readonly="true" id="hour"></div>
                        <div class="time-picker-down noselect" id="hour-down"></div>
                    </div>
                    <span>:</span>
                    <div class="time-picker-box">
                        <div class="time-picker-up noselect" id="minute-up"></div>
                        <div class="time-picker-val"><input type="text" value="MM" readonly="true" id="minute"></div>
                        <div class="time-picker-down noselect" id="minute-down"></div>
                    </div>
                </div>
                <div id="datepicker_retour" class="retour-datetime-aeroport" style="display: none;">
                    <div class="titre">
                        <h3>
                            Choisissez la date de votre vol de retour
                        </h3>
                    </div>
                </div>
                <div class="time-picker retour-datetime-aeroport">
                    <div class="titre">
                        <h3>
                            Heure d'attérissage de votre vol
                        </h3>
                    </div>
                    <div class="time-picker-box">
                        <div class="time-picker-up noselect" id="hour-up"></div>
                        <div class="time-picker-val"><input type="text" value="HH" readonly="true" id="hour"></div>
                        <div class="time-picker-down noselect" id="hour-down"></div>
                    </div>
                    <span>:</span>
                    <div class="time-picker-box">
                        <div class="time-picker-up noselect" id="minute-up"></div>
                        <div class="time-picker-val"><input type="text" value="MM" readonly="true" id="minute"></div>
                        <div class="time-picker-down noselect" id="minute-down"></div>
                    </div>
                </div>
                <div id="vol_aller_right" style="display: none;">
                    <div class="titre">
                        <h3>
                            Sélectionnez votre numéro de vol aller
                        </h3>
                    </div>
                    <ul id = 'vols-aller'>
                        <p class="info">
                            Le numéro de votre vol se trouve sur votre billet d'avion, ou sur le mail que vous avez reçu lors de votre réservation.
                        </p>
                        <img src="<?php echo ROOT;?>images/billet.png" style="  margin: 0;   padding: 0;  width: 100%;">
                    </ul>
                </div>
                <div id="vol_retour_right" style="display: none;">
                    <div class="titre">
                        <h3>
                            Sélectionnez votre numéro de vol retour
                        </h3>
                    </div>
                    <ul id = 'vols-retour'>
                        <p class="info">
                            Le numéro de votre vol se trouve sur votre billet d'avion, ou même sur le mail que vous avez reçu lors de votre réservation.
                        </p>
                        <img src="<?php echo ROOT;?>images/billet.png" style="  margin: 0;   padding: 0;  width: 100%;">
                    </ul>
                </div>
            </div>
        </div>
    </div>

<!-- reservation mobile left-->
    <div class = 'formulaire form-mob'>
        <div class="left-bloc">
            <div class="contenu" id="option-reservation-left">
                <div class="titre">
                    <h3>
                        Choisissez votre lieu de prise en charge
                    </h3>
                </div>
                <div class="selecteur">
                    <input type="radio" name="lieu" value="0" id="aeroport" />
                    <label for="aeroport"><span></span>AEROPORTS</label>
                    <input type="radio" name="lieu" value="1" id="gares" />
                    <label for="gares"><span></span>GARES</label>
                    <input type="radio" name="lieu" value="2" id="ville" />
                    <label for="ville"><span></span>VILLE</label>
                </div>
                <div class="separateur"></div>
                <input type="text" onfocus="this.type='date';this.setAttribute('onfocus','');this.blur();this.focus();" name="date_aller" id="date_aller" placeholder="Date aller" class="date-aller">
                <input type="text" onfocus="this.type='time';this.setAttribute('onfocus','');this.blur();this.focus();" name="heure_aller" id="heure_aller" placeholder="Heure aller" class="date-aller min-aller">

                <!--<label for="date_aller" id="label-date-aller">à HH:MM</label>-->
                <img class="ui-datepicker-trigger" src="images/date.png" alt="..." title="...">
                <input type="text" name="vol_aller" id="vol_aller" placeholder="N° vol aller" class="vol-aller">
                <img class="vol-aller-picto vol-aller-src" src="images/vol_aller.png" alt="..." title="...">
                <select name="terminal_aller" id="terminal_aller" class="vol-aller">
                    <?php $terms=DB::select(["*"], SPOT_TABLE);foreach($terms as $term) echo "<option value=\"{$term['id']}\">{$term['nom']}</option>"; ?>
                </select>
                <img class="vol-aller-picto vol-terminal-src" src="images/compagnie.png" alt="..." title="...">
                <div style="width: 100%; height: 30px;"></div>
                <input type="text" onfocus="this.type='date';this.setAttribute('onfocus','');this.blur();this.focus();" name="date_retour" id="date_retour" placeholder="Date retour" class="date-aller">
                <input type="text" onfocus="this.type='time';this.setAttribute('onfocus','');this.blur();this.focus();" name="heure_retour" id="heure_retour" placeholder="Heure retour" class="date-aller min-aller">

                <!--<label for="date_retour" id="label-date-retour">à HH:MM</label>-->
                <img class="ui-datepicker-trigger" src="images/date.png" alt="..." title="...">
                <input type="text" name="vol_retour" id="vol_retour" placeholder="N° vol retour" class="vol-aller">
                <img class="vol-aller-picto vol-retour-src" src="images/vol_retour.png" alt="..." title="...">
                <select name="terminal_retour" id="terminal_retour" class="vol-aller">
                    <?php $terms=DB::select(["*"], SPOT_TABLE);foreach($terms as $term) echo "<option value=\"{$term['id']}\">{$term['nom']}</option>"; ?>
                </select>
                <img class="vol-aller-picto vol-terminal-src" src="images/compagnie.png" alt="..." title="...">
                <p>Je ne connais pas mes numéros de vols</p>
                <div class="bouton-action" id="commander">Commander un edgar</div>
            </div>
        </div>
    </div>
    <!-- END /reservation mobile left-->
</div>

<!-- reservation option left-->
<div class="bloc1" id="option-reservation" style="display: none;">
    <div class = 'formulaire content mob-no-c'>
        <div class="left-bloc options">
            <div class="contenu" id="option-reservation-right">
                <div class="titre">
                    <h3>
                        Réservez votre parking avec voiturier
                    </h3>
                </div>
                <div class="sous-titre">
                    <p>
                        Afin de vous offir le meilleur service, nous faisons évoluer nos prix en fonction des horaires de prises en charge du véhicule. Choisissez l'horaire qui vous convient le mieux dans la liste ci-dessous.
                    </p>
                </div>
                <div class="option-date">
                    27/08/2015
                </div>
                <ul class="prix">

                </ul>
                <div class="option-options">
                    Ajouter des options
                </div>
                <ul class="liste-options">
                </ul>
            </div>
        </div>
<!-- reservation option right -->
        <div class="right-bloc options">
            <div class="contenu" id="option-reservation-right">
                <div class="recap-commande">
                    <div class="infos">
                        <div class="titre">
                            ALLER : le <span id="recap-vol-aller-date">27/09/2015</span>
                        </div>
                        <div class="contenu">
                            n° de vol : <span id="recap-vol-aller-number">AF007</span>
                        </div>
                        <div class="horraire">
                            Heure de prise en charge : <span id="recap-vol-aller-time">13h45</span>
                        </div>
                    </div>
                    <div class="separateur"></div>
                    <div class="infos">
                        <div class="titre">
                            RETOUR : le <span id="recap-vol-retour-date">27/09/2015</span>
                        </div>
                        <div class="contenu">
                            n° de vol : <span id="recap-vol-retour-number">AF007</span>
                        </div>
                        <div class="horraire">
                            Heure de prise en charge : <span id="recap-vol-retour-time">13h45</span>
                        </div>
                    </div>
                </div>
                <div class="titre">
                    <h3>
                        Récapitulatif de votre commande
                    </h3>
                </div>
                <div class="recap-commande">
                    <div class="infos">
                        <div class="titre">
                            Parking + voiturier
                        </div>
                        <div class="contenu">
                            -7j de stationnement <span id="prix-parking">84€</span>
                        </div>
                        <div class="titre">
                            Options
                        </div>
                        <div class="contenu" id="liste-options-selected">

                        </div>
                    </div>
                </div>
                <div class="recap-commande">
                    <div class="infos">
                        <div class="total">
                            TOTAL T.T.C <span id="prix-total">148€</span>
                        </div>
                    </div>
                </div>
                <div class="bouton-action" id="finaliser">Finaliser ma commande</div>
            </div>
        </div>
    </div>
    <div style="display:none" id="prixId"></div>
</div>

<script type="text/javascript">

    $(document).ready(function()
    {

        //var isMobile = $(window).width()<1000;
        if(isMobile){
            $(".formulaire.form-desk").remove();
            $(".formulaire.form-mob").show();
        }
        else{
            $(".formulaire.form-mob").remove();
            $(".formulaire.form-desk").show();
        }
        window.stateView = '0'; // aeroport: '0', gare: '1', ville '2'

        var changeView = function (){
            stateView = $(this).val();
            if ($(this).val() == '1') { //gare
                $("#vol_aller").attr("placeholder", "N° train aller");
                $("#vol_retour").attr("placeholder", "N° train retour");
                $(".vol-aller-picto.vol-aller-src").attr("src", "images/train_terminal.png");
                $(".vol-aller-picto.vol-retour-src").attr("src", "images/train_retour.png");
                $(".vol-aller-picto.vol-terminal-src").attr("src", "images/train_terminal.png");
                $("#datepicker_aller h3").html("Choisissez la date de votre train de départ");
                $("#vol_aller_right h3").html("Sélectionnez votre numéro de train aller");
                $("#vols-aller .info").html("Le numéro de votre train se trouve sur votre billet, ou sur le mail que vous avez reçu lors de votre réservation.");
                $("#vols-aller img").attr("src", "http://localhost/edgar_city/images/billet-train.png");
                $("#datepicker_retour h3").html("Choisissez la date de votre train de retour");
                $("#vol_retour_right h3").html("Sélectionnez votre numéro de train retour");
                $("#vols-retour .info").html("Le numéro de votre train se trouve sur votre billet, ou sur le mail que vous avez reçu lors de votre réservation.");
                $("#vols-retour img").attr("src", "http://localhost/edgar_city/images/billet-train.png");
                $("#terminal_aller").children().not(".train").hide();
                $("#terminal_retour").children().not(".train").hide();
                $(".time-picker.retour-datetime-aeroport h3").html("Heure d'arrrivée de votre train");
            }
        if ($(this).val() == '0') { //gare
            $("#vol_aller").attr("placeholder", "N° vol aller");
            $("#vol_retour").attr("placeholder", "N° vol retour");
            $(".vol-aller-picto.vol-aller-src").attr("src", "images/compagnie.png");
            $(".vol-aller-picto.vol-retour-src").attr("src", "images/vol_retour.png");
            $(".vol-aller-picto.vol-terminal-src").attr("src", "images/compagnie.png");
            $("#datepicker_aller h3").html("Choisissez la date de votre vol de départ");
            $("#vol_aller_right h3").html("Sélectionnez votre numéro de vol aller");
            $("#vols-aller .info").html("Le numéro de votre vol se trouve sur votre billet d'avion, ou sur le mail que vous avez reçu lors de votre réservation.");
            $("#vols-aller img").attr("src", "http://localhost/edgar_city/images/billet-train.png");
            $("#datepicker_retour h3").html("Choisissez la date de votre vol de retour");
            $("#vol_retour_right h3").html("Sélectionnez votre numéro de vol retour");
            $("#vols-retour .info").html("Le numéro de votre vol se trouve sur votre billet d'avion, ou sur le mail que vous avez reçu lors de votre réservation.");
            $("#vols-retour img").attr("src", "http://localhost/edgar_city/images/billet.png");
            $("#terminal_aller").children().not(".train").hide();
            $("#terminal_retour").children().not(".train").hide();
            $(".time-picker.retour-datetime-aeroport h3").html("Heure d'attérissage de votre vol");
        }
        };
        $("input[name=lieu]").change(changeView);

        $('ul.prix').on("click", "li", function(){
            $(".prix>.selected").removeClass("selected");
            $(this).addClass("selected");

            var prixParking = parseFloat($(this).data("prix"));
            $(".recap-commande>.infos>.contenu>#prix-parking").html(prixParking+"€");
            $("#prixId").data("id", $(this).data("id"));

            var prixOptions = 0;
            $('input[type=checkbox]:checked').each(function () {
                prixOptions += parseFloat($(this).data("prix"));
            });

            var prixTotal = prixOptions + prixParking;
            $("#prix-total").html(prixTotal+"€");
        });

/*        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
*/
        $(document).on("ifChanged", "input.checkbox-dyn", function(){
            var nom = "";
            var prix = "";
            var text = "";
            var prixOptions = 0;
            $('input[type=checkbox]:checked').each(function () {
                nom = $(this).data("nom");
                prix = $(this).data("prix");
                text += nom+'<span id="prix-options">'+prix+'€</span><br>';
                prixOptions += parseFloat($(this).data("prix"));
            });
            $('#liste-options-selected').html(text);

            var prixParking = parseFloat($(".options>.contenu>.prix>li.selected").data("prix"));
            var prixTotal = prixOptions + prixParking;
            $("#prix-total").html(prixTotal+"€");
        });

        function format2digits(n){
            return n > 9 ? "" + n: "0" + n;
        }

        $("#vol_aller").keyup(function(){
            var t = {};
            t.search = $("#vol_aller").val();
            if($("#vol_aller").val().length>1){
                var requestName = (stateView == '0') ? 'validVol' : 'validtrain'
                var test = requeteAjax(requestName, t);
                if(typeof test.Results[0] == "undefined"){
                    $('#vols-aller').children().remove();
                    var $errorMessage = (stateView == '0')
                        ? $('<p class="warning">Aucun numéro de vol ne correspond à votre recherche</p>')
                        : $('<p class="warning">Aucun numéro de train ne correspond à votre recherche</p>');
                    $errorMessage.appendTo('#vols-aller');
                }else{
                    $('#vols-aller').children().remove();
                    jQuery.each(test.Results, function(i, val) {
                        var num = val.Value;
                        $('<li class="li-vol-aller" id="'+num+'">'+num+'</li>').appendTo('#vols-aller').click(function(){
                            var num = $(this).attr('id');
                            $("#vol_aller").val(num);

                        });
                    });
                }
            }
        });

        $("#vol_retour").keyup(function(){
            var t = {};
            t.search = $("#vol_retour").val();
            if($("#vol_retour").val().length>1){
                var requestName = (stateView == '0') ? 'validVol' : 'validtrain'
                var test = requeteAjax(requestName, t);
                if(typeof test.Results[0] == "undefined"){
                    $('#vols-retour').children().remove();
                    var $errorMessage = (stateView == '0')
                        ? $('<p class="warning">Aucun numéro de vol ne correspond à votre recherche</p>')
                        : $('<p class="warning">Aucun numéro de train ne correspond à votre recherche</p>');
                    $errorMessage.appendTo('#vols-aller');
                }else{
                    $('#vols-retour').children().remove();
                    jQuery.each(test.Results, function(i, val) {
                        var num = val.Value;
                        $('<li class="li-vol-retour" id="'+num+'">'+num+'</li>').appendTo('#vols-retour').click(function(){
                            var num = $(this).attr('id');
                            $("#vol_retour").val(num);

                        });
                    });
                }
            }
        });


        $(".aller-datetime-aeroport>.time-picker-box>#hour-up").click(function(){
            var hour = $(".aller-datetime-aeroport>.time-picker-box>.time-picker-val").children('#hour');
            var h = parseInt(hour.val());
            if(h<23){
                hour.val(format2digits(parseInt(hour.val())+1));

            }else{
                hour.val(format2digits(parseInt(06)));
            }
            $("#label-date-aller").html('à '+$(".aller-datetime-aeroport>.time-picker-box>.time-picker-val").children('#hour').val()+" : " + $(".aller-datetime-aeroport>.time-picker-box>.time-picker-val").children('#minute').val());
        });

        $(".aller-datetime-aeroport>.time-picker-box>#hour-down").click(function(){
            var hour = $(".aller-datetime-aeroport>.time-picker-box>.time-picker-val").children('#hour');
            var h = parseInt(hour.val());
            if(h>7){
                hour.val(format2digits(parseInt(hour.val())-1));
            }else{
                hour.val(format2digits(parseInt(23)));
            }
            $("#label-date-aller").html('à '+$(".aller-datetime-aeroport>.time-picker-box>.time-picker-val").children('#hour').val()+" : " + $(".aller-datetime-aeroport>.time-picker-box>.time-picker-val").children('#minute').val());

        });

        $(".aller-datetime-aeroport>.time-picker-box>#minute-up").click(function(){
            var hour = $(".aller-datetime-aeroport>.time-picker-box>.time-picker-val").children('#minute');
            var h = parseInt(hour.val());
            if(h<55){
                hour.val(format2digits(parseInt(hour.val())+5));
            }else{
                hour.val(format2digits(parseInt(00)));
            }
            $("#label-date-aller").html('à '+$(".aller-datetime-aeroport>.time-picker-box>.time-picker-val").children('#hour').val()+" : " + $(".aller-datetime-aeroport>.time-picker-box>.time-picker-val").children('#minute').val());

        });

        $(".aller-datetime-aeroport>.time-picker-box>#minute-down").click(function(){
            var hour = $(".aller-datetime-aeroport>.time-picker-box>.time-picker-val").children('#minute');
            var h = parseInt(hour.val());
            if(h>4){
                hour.val(format2digits(parseInt(hour.val())-5));
            }else{
                hour.val(format2digits(parseInt(55)));
            }
            $("#label-date-aller").html('à '+$(".aller-datetime-aeroport>.time-picker-box>.time-picker-val").children('#hour').val()+" : " + $(".aller-datetime-aeroport>.time-picker-box>.time-picker-val").children('#minute').val());

        });

        $(".retour-datetime-aeroport>.time-picker-box>#hour-up").click(function(){
            var hour = $(".retour-datetime-aeroport>.time-picker-box>.time-picker-val").children('#hour');
            var h = parseInt(hour.val());
            if(h<23){
                hour.val(format2digits(parseInt(hour.val())+1));

            }else{
                hour.val(format2digits(parseInt(06)));
            }
            $("#label-date-retour").html('à '+$(".retour-datetime-aeroport>.time-picker-box>.time-picker-val").children('#hour').val()+" : " + $(".retour-datetime-aeroport>.time-picker-box>.time-picker-val").children('#minute').val());
        });

        $(".retour-datetime-aeroport>.time-picker-box>#hour-down").click(function(){
            var hour = $(".retour-datetime-aeroport>.time-picker-box>.time-picker-val").children('#hour');
            var h = parseInt(hour.val());
            if(h>7){
                hour.val(format2digits(parseInt(hour.val())-1));
            }else{
                hour.val(format2digits(parseInt(23)));
            }
            $("#label-date-retour").html('à '+$(".retour-datetime-aeroport>.time-picker-box>.time-picker-val").children('#hour').val()+" : " + $(".retour-datetime-aeroport>.time-picker-box>.time-picker-val").children('#minute').val());

        });

        $(".retour-datetime-aeroport>.time-picker-box>#minute-up").click(function(){
            var hour = $(".retour-datetime-aeroport>.time-picker-box>.time-picker-val").children('#minute');
            var h = parseInt(hour.val());
            if(h<55){
                hour.val(format2digits(parseInt(hour.val())+5));
            }else{
                hour.val(format2digits(parseInt(00)));
            }
            $("#label-date-retour").html('à '+$(".retour-datetime-aeroport>.time-picker-box>.time-picker-val").children('#hour').val()+" : " + $(".retour-datetime-aeroport>.time-picker-box>.time-picker-val").children('#minute').val());

        });

        $(".retour-datetime-aeroport>.time-picker-box>#minute-down").click(function(){
            var hour = $(".retour-datetime-aeroport>.time-picker-box>.time-picker-val").children('#minute');
            var h = parseInt(hour.val());
            if(h>4){
                hour.val(format2digits(parseInt(hour.val())-5));
            }else{
                hour.val(format2digits(parseInt(55)));
            }
            $("#label-date-retour").html('à '+$(".retour-datetime-aeroport>.time-picker-box>.time-picker-val").children('#hour').val()+" : " + $(".retour-datetime-aeroport>.time-picker-box>.time-picker-val").children('#minute').val());

        });



    });

</script>

