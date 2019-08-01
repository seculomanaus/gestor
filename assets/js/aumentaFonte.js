<!-- Função para aumentar e diminuir a fonte da prova -->
        <script>
        $(document).ready(function(){

                    var $elemento = $("body #PainelQuestao").find("*"); //encontra todos os elementos dentro do #container
                    var conteudo = '.content';
                    var fonts = [];

                    function obterTamanhoFonte() {
                        for (var i = 0; i < $elemento.length; i++) {
                            fonts.push(parseFloat($elemento.eq(i).css('font-size')));
                        }
                        normal = $("body .content").css('font-size');

                    }
                    obterTamanhoFonte();

            
                    $('#aumentar').on('click', function (e) {
                        for (var i = 0; i < $elemento.length; i++) {
                            ++fonts[i];
                            $elemento.eq(i).css('font-size', fonts[i]);
                        }
                    });

                    $('#diminuir').on('click', function (e) {
                        for (var i = 0; i < $elemento.length; i++) {
                            --fonts[i];
                            $elemento.eq(i).css('font-size', fonts[i]);
                        }
                    });
                });        
        </script>