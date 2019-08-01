<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="SISTEMA DE GESTÃO DE PROVAS ONLINE">
        <meta name="auhor" content="Silvio Silva de Souza">
        <meta name="mail" content="silvio.souza@seculomanaus.com.br">
        <title>SISTEMA DE GESTÃO ACADÊMICA ONLINE</title>
        <!-- Vendor styles -->
        <link rel="stylesheet" href="<?= base_url('assets/css/font-awesome.min.css') ?>" />
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css') ?>" />
        <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
        <link href="<?= base_url('assets/css/jquery.circliful.css') ?>" rel="stylesheet" type="text/css" />
        
        <!-- Vendor scripts -->
        <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/jquery-ui.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/jquery.circliful.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/bloqueiaseta.js') ?>"></script>
        <style class="cp-pen-styles">


.container{}
.row{}
.circle{
  background: #ffffff;
  padding: 15px 10px;
  text-align: center;
  border: 7px solid #F2F2F2;
    
    transition: all 0.5s;
  -moz-transition: all 0.5s; /* Firefox 4 */
  -webkit-transition: all 0.5s; /* Safari and Chrome */
  -o-transition: all 0.5s; /* Opera */
 
}
.circle h4{
  margin: 0;
  padding: 0;
}
.circle p{}
.circle span{}
.circle span.icon{
}
.circle span.icon i{
  font-size: 20px;
}
.circle span.price-large{
  font-size: 20px
}

.c1:hover{
  background: #39b3d7;
  color: #ffffff;
}
.c1 .blue{
  color: #39b3d7;
}
.c1:hover .blue{
  color: #ffffff;
}

.c2:hover{
  background: #ed9c28;
  color: #ffffff;
}
.c2 .yellow{
  color: #ed9c28;
}
.c2:hover .yellow{
  color: #ffffff;
}

.c3{
  background: #47a447;
  color: #ffffff;
}
.c3 .green{
  color: #47a447;
}
.c3 .green{
  color: #ffffff;
}

.c4:hover{
  background: #d2322d;
  color: #ffffff;
}
.c4 .red{
  color: #d2322d;
}
.c4:hover .red{
  color: #ffffff;
}</style>
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <!-- <body> -->
      <body onselectstart="return false" oncontextmenu="return false" ondragstart="return false" onMouseOver="window.status='..Não permitido .. '; return true;">
        
        <div class="color-line" style="height: 20px"></div>
        <div class="row text-center">
            <br><br><br>
            <h3><?=$lista[0]['TITULO']?></h3>
        </div>
        <div class="row">
            <div class="col-sm-2 col-lg-offset-1">
                <br><br><br>
                <div class="hpanel hyellow">
                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img width='150' src="http://server01/academico/usuarios/foto?codigo=<?=$this->session->userdata('PVO_USER')?>" class="img-rounded">
                        </a>
                        <div class="media-body">
                            <h6><?=$this->session->userdata('PVO_NOME')?></h6>
                            <small class="text-muted">
                                <?= $questao->TITULO ?>
                            </small>
                        </div>
                        <hr>

                        <span class="btn-group">
                            <!--a href="<?=base_url('home/index')?>" class="btn btn-warning2" style="font-size: 15px">
                                <i class="fa fa-list"></i> Provas
                            </a-->
                            <a href="<?=base_url('usuario/logout')?>" class="btn btn-danger2 btn-lg" style="font-size: 15px">
                                <i class="fa fa-sign-out"></i> Sair do Sistema
                            </a>
                        </span>
                    </div>
                </div>
            </div>
          
            <div class="col-sm-8">
                <h5 class="blue"> PROVA FINALIZADA  </h5>
                <br><br><br>
                    <div class="col-sm-4 hpanel hyellow border-right border-bottom">
                    <label><?=$materia?></label>
                    <div class="row">
                        <div class="col-sm-4 text-center">
                            <div class="circle c1 img-circle">                                
                                <span class="price-large blue">
                                    <?=$lista[0]['NR_ACERTO']?></small>
                                </span>
                            </div>
                            <h5 class="blue">ACERTO<?=(($lista[0]['NR_ACERTO'] > 1)? 'S' : '')?></h5>
                        </div>
                        <div class="col-sm-4 text-center"> 
                            <div class="circle c4 img-circle">                                
                                <span class="price-large red">
                                    <?=$lista[0]['NR_ERRO']?></small>
                                </span>
                            </div>
                            <h5 class="blue">ERRO<?=(($lista[0]['NR_ERRO'] > 1)? 'S' : '')?></h5>
                        </div>
                      
                        <div class="col-sm-4 text-center">
                            <div class="circle c3 img-circle">                                
                                <span class="price-large green">
                                    <?=$lista[0]['NR_NOTA']?>
                                </span>
                            </div>
                            <h5 class="blue">NOTA</h5>
                        </div>
                    
                    </div>
                </div>
                
            </div>    
               
        </div>


        <div class="col-sm-12">
            <div class="hpanel hyellow">
                <div class="col-sm-12 text-center">
                    
                </div>
            </div>
        </div>
        <div id="footer">
            <div class="bg-primary" style="position: fixed; bottom: 0px; width:100%; z-index: 9999999999999">
                <div class="color-line" style="height: 20px"></div>
            </div>
        </div>   
    </body>
</html>