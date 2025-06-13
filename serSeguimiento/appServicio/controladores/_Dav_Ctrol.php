<?php
//gen davidserrudoqgmail.com

class _Dav_Ctrol
{
    public $M_Usuario = null;
    public $M_Usuariologueado = null;
    public function __construct()
    {
        $this->M_Usuario = new M_Usuario();
        $this->M_Usuariologueado = new M_Usuariologueado();
    }
    public function ValidaUser($f3)
    {
        $msg = 'OK';
        $nombreusuario = is_null($f3->get('POST.nombreusuario')) ? 'T' : $f3->get('POST.nombreusuario');
        $clave = is_null($f3->get('POST.clave')) ? '' : $f3->get('POST.clave');
        //$this->M_Usuario->load(['usuario = ?', $nombreusuario]);
        $this->M_Usuario->load(['usuario = ? AND estadoregistro = ?', $nombreusuario, 1]);
        $pclave = $this->M_Usuario->get('clave');
        if ($this->validate_pw($clave, $pclave)) {

            //registramos la session
            $Tipo = 'C';
            $idusuariologueado = $this->M_Usuario->get('idusuario');
            $idusuario = $this->M_Usuario->get('idusuario');
            $idrolusuario =1; // $this->M_Usuario->get('idtipousuario');
            $date = getdate();
            $llave = crypt(date("Y-m-d H:i:s"));
            $idestadollave = 1;
            $fecha = date("Y-m-d H:i:s");
            $direccionip = 'NA';
            $direccionhost = 'NA';
            $direcciondest = 'NA';
            $idsucursal = 1; // $this->M_Usuario->get('idsucursal');
            $sql = "CALL pcontrolsesion('" . $Tipo . "','" . $idusuariologueado . "','" . $idusuario . "','" . $idrolusuario . "','" . $llave . "','" . $idestadollave . "','" . $fecha . "','" . $direccionip . "','" . $direccionhost . "','" . $direcciondest . "','" . $idsucursal . "'); ";
            $resulto = $f3->get('DB')->exec($sql);
            $this->M_Usuariologueado->load(['idusuario = ? and idestadollave=1', $idusuariologueado]);
            $items = array();
            //devolvemos el objeto
            $items = $this->M_Usuariologueado->cast();
        } else {
            $msg = 'FAILD';
            $items = "";
        }
        echo json_encode([
            'mesaje' => $msg,
            'info' => [
                'item' => $items
            ]
        ]);
    }

    public function davprocedure($f3)
    {
        $idusuario = is_null($f3->get('POST.idusuario')) ? 'T' : $f3->get('POST.idusuario');
        $llave = is_null($f3->get('POST.llave')) ? 'T' : $f3->get('POST.llave');
        if ($this->M_Usuariologueado->ValidaSession($idusuario, $llave, 'davprocedure')) {
            $pnombreprocedure = is_null($f3->get('POST.pnombreprocedure')) ? 'T' : $f3->get('POST.pnombreprocedure');
            $pCampo0 = is_null($f3->get('POST.pCampo0')) ? 'T' : $f3->get('POST.pCampo0');
            $pValor0 = is_null($f3->get('POST.pValor0')) ? '' : $f3->get('POST.pValor0');
            $pCampo1 = is_null($f3->get('POST.pCampo1')) ? 'T' : $f3->get('POST.pCampo1');
            $pValor1 = is_null($f3->get('POST.pValor1')) ? '' : $f3->get('POST.pValor1');
            $pCampo2 = is_null($f3->get('POST.pCampo2')) ? 'T' : $f3->get('POST.pCampo2');
            $pValor2 = is_null($f3->get('POST.pValor2')) ? '' : $f3->get('POST.pValor2');
            $pCampo3 = is_null($f3->get('POST.pCampo3')) ? 'T' : $f3->get('POST.pCampo3');
            $pValor3 = is_null($f3->get('POST.pValor3')) ? '' : $f3->get('POST.pValor3');
            $pCampo4 = is_null($f3->get('POST.pCampo4')) ? 'T' : $f3->get('POST.pCampo4');
            $pValor4 = is_null($f3->get('POST.pValor4')) ? '' : $f3->get('POST.pValor4');
            $pCampo5 = is_null($f3->get('POST.pCampo5')) ? 'T' : $f3->get('POST.pCampo5');
            $pValor5 = is_null($f3->get('POST.pValor5')) ? '' : $f3->get('POST.pValor5');
            $pCampo6 = is_null($f3->get('POST.pCampo6')) ? 'T' : $f3->get('POST.pCampo6');
            $pValor6 = is_null($f3->get('POST.pValor6')) ? '' : $f3->get('POST.pValor6');
            $pCampo7 = is_null($f3->get('POST.pCampo7')) ? 'T' : $f3->get('POST.pCampo7');
            $pValor7 = is_null($f3->get('POST.pValor7')) ? '' : $f3->get('POST.pValor7');
            $sql = "CALL " . $pnombreprocedure . "('" . $pCampo0 . "','" . $pValor0 . "','" . $pCampo1 . "','" . $pValor1 . "','" . $pCampo2 . "','" . $pValor2
                . "','" . $pCampo3 . "','" . $pValor3 . "','" . $pCampo4 . "','" . $pValor4 . "','" . $pCampo5 . "','" . $pValor5
                . "','" . $pCampo6 . "','" . $pValor6 . "','" . $pCampo7 . "','" . $pValor7 . "'); ";
            try {
                $resulto = $f3->get('DB')->exec($sql);
                $items = array();
                $msg = 'e pro';
                $items = $resulto;
                echo json_encode([
                    'mesaje' => $msg,
                    'info' => [
                        'item' => $items
                    ]
                ]);
            } catch (PDOException $e) {
                echo json_encode('{"error" : { "text":' . $e->getMessage() . '}');
                $resulto = $f3->get('DB')->exec($sql);
                $items = array();
                $msg = 'Compra registrada';
                $items = $resulto;
                echo json_encode([
                    'mesaje' => $msg,
                    'info' => [
                        'item' => $items
                    ]
                ]);
            } catch (PDOException $e) {
                echo json_encode('{"error" : { "text":' . $e->getMessage() . '}');
            }
        } else {
            $msg = 'llave no valida';
            $items = '';
            echo json_encode([
                'mesaje' => $msg,
                'info' => [
                    'item' => $items
                ]
            ]);
        }
    }


    
public function Cambiarpassword($f3){
   $idusuario = is_null($f3->get('POST.idusuario')) ? 'T' : $f3->get('POST.idusuario');
$llave = is_null($f3->get('POST.llave')) ? 'T' : $f3->get('POST.llave');
if ($this->M_Usuariologueado->ValidaSession($idusuario, $llave,'updUsuario',$f3)) {
$Tipo = 'U';
$idusuario = is_null($f3->get('POST.pidusuario')) ? 'T' : $f3->get('POST.pidusuario');
$cedula = is_null($f3->get('POST.pcedula')) ? 'T' : $f3->get('POST.pcedula');
$nombres = is_null($f3->get('POST.pnombres')) ? 'T' : $f3->get('POST.pnombres');
$primerapellido = is_null($f3->get('POST.pprimerapellido')) ? 'T' : $f3->get('POST.pprimerapellido');
$segundoapellido = is_null($f3->get('POST.psegundoapellido')) ? 'T' : $f3->get('POST.psegundoapellido');
$fechanacimiento = is_null($f3->get('POST.pfechanacimiento')) ? 'T' : $f3->get('POST.pfechanacimiento');
$usuario = is_null($f3->get('POST.pusuario')) ? 'T' : $f3->get('POST.pusuario');
$clave = is_null($f3->get('POST.pclave')) ? 'T' : crypt($f3->get('POST.pclave'));
$estadousuario = is_null($f3->get('POST.pestadousuario')) ? 'T' : $f3->get('POST.pestadousuario');
$sql = "CALL seg_pagUsuario('" . $Tipo . "','". $idusuario . "','". $cedula . "','". $nombres . "','". $primerapellido . "','". $segundoapellido . "','". $fechanacimiento . "','". $usuario . "','". $clave . "','". $estadousuario. "'); "; 
try {
$resulto = $f3->get('DB')->exec($sql);
$items = array();
$msg = 'upds Usuario';
$items = $resulto;
echo json_encode([
'mesaje' => $msg,
'info' => [
'item' => $items
]
]);
} catch (PDOException $e) {
echo json_encode('{"error" : { "text":' . $e->getMessage() . '}');
$resulto = $f3->get('DB')->exec($sql);
$items = array();
$msg = 'Usuario registrada';
$items = $resulto;
echo json_encode([
'mesaje' => $msg,
'info' => [
'item' => $items
]
]);
} catch (PDOException $e) {
echo json_encode('{"error" : { "text":' . $e->getMessage() . '}');
}
} else {
 $msg = 'llave no valida';
$items = '';
echo json_encode([
'mesaje' => $msg,
'info' => [
'item' => $items
]
]);
} 
}
public function Creapassword($f3){
   $idusuario = is_null($f3->get('POST.idusuario')) ? 'T' : $f3->get('POST.idusuario');
$llave = is_null($f3->get('POST.llave')) ? 'T' : $f3->get('POST.llave');
if ($this->M_Usuariologueado->ValidaSession($idusuario, $llave,'addUsuario',$f3)) {
$Tipo = 'C';
$idusuario = is_null($f3->get('POST.pidusuario')) ? 'T' : $f3->get('POST.pidusuario');
$cedula = is_null($f3->get('POST.pcedula')) ? 'T' : $f3->get('POST.pcedula');
$nombres = is_null($f3->get('POST.pnombres')) ? 'T' : $f3->get('POST.pnombres');
$primerapellido = is_null($f3->get('POST.pprimerapellido')) ? 'T' : $f3->get('POST.pprimerapellido');
$segundoapellido = is_null($f3->get('POST.psegundoapellido')) ? 'T' : $f3->get('POST.psegundoapellido');
$fechanacimiento = is_null($f3->get('POST.pfechanacimiento')) ? 'T' : $f3->get('POST.pfechanacimiento');
$usuario = is_null($f3->get('POST.pusuario')) ? 'T' : $f3->get('POST.pusuario');
$clave = is_null($f3->get('POST.pclave')) ? 'T' : crypt($f3->get('POST.pclave'));
$estadousuario = is_null($f3->get('POST.pestadousuario')) ? 'T' : $f3->get('POST.pestadousuario');
$sql = "CALL seg_pagUsuario('" . $Tipo . "','". $idusuario . "','". $cedula . "','". $nombres . "','". $primerapellido . "','". $segundoapellido . "','". $fechanacimiento . "','". $usuario . "','". $clave . "','". $estadousuario. "'); "; 
try {
$resulto = $f3->get('DB')->exec($sql);
$items = array();
$msg = 'add Usuario';
$items = $resulto;
echo json_encode([
'mesaje' => $msg,
'info' => [
'item' => $items
]
]);
} catch (PDOException $e) {
echo json_encode('{"error" : { "text":' . $e->getMessage() . '}');
$resulto = $f3->get('DB')->exec($sql);
$items = array();
$msg = 'Usuario registrada';
$items = $resulto;
echo json_encode([
'mesaje' => $msg,
'info' => [
'item' => $items
]
]);
} catch (PDOException $e) {
echo json_encode('{"error" : { "text":' . $e->getMessage() . '}');
}
} else {
 $msg = 'llave no valida';
$items = '';
echo json_encode([
'mesaje' => $msg,
'info' => [
'item' => $items
]
]);
} 
}
    public function CreapasswordAnt($f3)
    {
        $idusuario = is_null($f3->get('POST.idusuario')) ? 'T' : $f3->get('POST.idusuario');
        $llave = is_null($f3->get('POST.llave')) ? 'T' : $f3->get('POST.llave');
        if ($this->M_Usuariologueado->ValidaSession($idusuario, $llave, 'addusuario', $f3)) {
            $Tipo = 'C';
            $idusuario = is_null($f3->get('POST.pidusuario')) ? 'T' : $f3->get('POST.pidusuario');
            $idpersona = is_null($f3->get('POST.pidpersona')) ? 'T' : $f3->get('POST.pidpersona');
            $nombreusuario = is_null($f3->get('POST.pnombreusuario')) ? 'T' : $f3->get('POST.pnombreusuario');
            $clave = is_null($f3->get('POST.pclave')) ? 'T' : crypt($f3->get('POST.pclave'));
            $salt = is_null($f3->get('POST.psalt')) ? 'T' : $f3->get('POST.psalt');
            $pin = is_null($f3->get('POST.ppin')) ? 'T' : $f3->get('POST.ppin');
            $idestadousuario = is_null($f3->get('POST.pidestadousuario')) ? 'T' : $f3->get('POST.pidestadousuario');
            $idtipousuario = is_null($f3->get('POST.pidtipousuario')) ? 'T' : $f3->get('POST.pidtipousuario');
            $estilo = is_null($f3->get('POST.pestilo')) ? 'T' : $f3->get('POST.pestilo');
            $idsucursal = is_null($f3->get('POST.pidsucursal')) ? 'T' : $f3->get('POST.pidsucursal');
            $idrol = is_null($f3->get('POST.pidrol')) ? 'T' : $f3->get('POST.pidrol');
            $sql = "CALL seg_pagusuario('" . $Tipo . "','" . $idusuario . "','" . $idpersona . "','" . $nombreusuario . "','" . $clave . "','" . $salt . "','" . $pin . "','" . $idestadousuario . "','" . $idtipousuario . "','" . $estilo . "','" . $idsucursal . "','" . $idrol . "'); ";
            try {
                $resulto = $f3->get('DB')->exec($sql);
                $items = array();
                $msg = '200';
                $items = $resulto;
                echo json_encode([
                    'mesaje' => $msg,
                    'info' => [
                        'item' => $items
                    ]
                ]);
            } catch (PDOException $e) {
                echo json_encode('{"error" : { "text":' . $e->getMessage() . '}');
                $resulto = $f3->get('DB')->exec($sql);
                $items = array();
                $msg = '500';
                $items = $resulto;
                echo json_encode([
                    'mesaje' => $msg,
                    'info' => [
                        'item' => $items
                    ]
                ]);
            } catch (PDOException $e) {
                echo json_encode('{"error" : { "text":' . $e->getMessage() . '}');
            }
        } else {
            $msg = '201';
            $items = '';
            echo json_encode([
                'mesaje' => $msg,
                'info' => [
                    'item' => $items
                ]
            ]);
        }
    }
    function validate_pw($password, $hash)
    {
        /* Regenerating the with an available hash as the options parameter should
         * produce the same hash if the same password is passed.
         */
        return crypt($password, $hash) == $hash;
    }
    public function fnDevuelveConsulta(
        $NombreVista = "",
        $Campo0 = "",
        $Valor0 = "",
        $Campo1 = "",
        $Valor1 = "",
        $Campo2 = "",
        $Valor2 = "",
        $Campo3 = "",
        $Valor3 = "",
        $Campo4 = "",
        $Valor4 = "",
        $Campo5 = "",
        $Valor5 = "",
        $Campo6 = "",
        $Valor6 = "",
        $Campo7 = "",
        $Valor7 = ""
    ) {
        $ps = "";
        $ps = $this->fnDevuelveCondicion($Campo0, $Valor0);
        $ps = $ps . $this->fnDevuelveCondicion($Campo1, '.' . $Valor1);
        $ps = $ps . $this->fnDevuelveCondicion($Campo2, '.' . $Valor2);
        $ps = $ps . $this->fnDevuelveCondicion($Campo3, '.' . $Valor3);
        $ps = $ps . $this->fnDevuelveCondicion($Campo4, '.' . $Valor4);
        $ps = $ps . $this->fnDevuelveCondicion($Campo5, '.' . $Valor5);
        $ps = $ps . $this->fnDevuelveCondicion($Campo6, '.' . $Valor6);
        $ps = $ps . $this->fnDevuelveCondicion($Campo7, '.' . $Valor7);
        $ps = 'SELECT  * from  ' . $NombreVista . $ps;
        return $ps;
    }
    public function fnDevuelveCondicion($Campo = "", $Valor = "")
    {
        //         string s = "good overview of ESP's in more detail than you probably need.";
        // string escaped = s.Replace("'","''");
        $Condicion = "";
        $Campo = str_replace("'", "", $Campo);
        $Valor = str_replace("'", "", $Valor);
        #consultamos un where
        if (substr($Valor, 0, 1) <> ".")
            $Condicion = " WHERE ";
        else {
            if (substr($Valor, 1, 1) == ".") {
                $Condicion = " OR ";
                $Valor = substr($Valor, 2, strlen($Valor) - 1);
            } else {
                $Condicion = " AND ";
                $Valor = substr($Valor, 1, strlen($Valor));
            }
        }
        #preguntas
        if (substr($Campo, 0, 1) == "C")
            $Condicion = $Condicion . substr($Campo, 1, strlen($Campo)) . " like " . "'" . "%" . $Valor . "%" . "'";

        if (substr($Campo, 0, 1) == "(")
            $Condicion = $Condicion . "(" . substr($Campo, 1, strlen($Campo)) . " like " . "'" . "%" . $Valor . "%" . "'";

        if (substr($Campo, 0, 1) == ")")
            $Condicion = $Condicion . "" . substr($Campo, 1, strlen($Campo)) . " like " . "'" . "%" . $Valor . "%" . "'" . ")";

        if (substr($Campo, 0, 1) == "I")
            $Condicion = $Condicion . "" . substr($Campo, 1, strlen($Campo)) . " like " . "'" . $Valor . "%" . "'";

        if (substr($Campo, 0, 1) == "N") {
            if (is_numeric($Valor))
                if ($Valor == "0")
                    $Condicion = "";
                else
                    $Condicion = $Condicion . "" . substr($Campo, 1, strlen($Campo)) . " = " . $Valor;
            else
                $Condicion = $Condicion . "" . substr($Campo, 1, strlen($Campo)) . " = 0";
        }

        //     if (substr($Campo,0, 1) ==  "D")  {
        //     	if(STR_TO_DATE(($Valor). "%d.%m.%Y") IS NOT NULL) {
        // 			$Condicion = $Condicion . "" . substr($Campo,1, strlen($Campo)) . " = " . "'" .  $Valor .  "'"    ;
        // 		else
        // 			$Condicion = $Condicion . "" . substr($Campo,1, strlen($Campo)) . " = " . "'" .  "01/01/1990" .  "'" ;
        // 		}
        //     }
        if (substr($Campo, 0, 1) == "T") {
            $Condicion = "";
        }

        if (substr($Campo, 0, 1) == "L") {
            $Condicion = $Condicion . "" . substr($Campo, 1, strlen($Campo)) . " = " . "'" . $Valor . "'";
        }
        if (substr($Campo, 0, 1) == "P") {
            $Condicion = $Condicion . substr($Campo, 1, strlen($Campo)) . " = " . $Valor;
        }
        if (substr($Campo, 0, 1) == "E") {
            $Condicion = $Condicion . "" . substr($Campo, 1, strlen($Campo)) . " <> " . "'" . $Valor . "'";
        }
        if (substr($Campo, 0, 1) == "O") {
            $Condicion = " order by " . substr($Campo, 1, strlen($Campo)) . " " . $Valor;
        }
        if (substr($Campo, 0, 1) == "Z") {
            $Condicion = $Condicion . "substr(" . substr($Campo, 1, strlen($Campo)) . ".2. strlen(" . substr($Campo, 1, strlen($Campo)) . ")) = " . $Valor;
        }
        if (substr($Campo, 0, 1) == ">") {
            $Condicion = $Condicion . "" . substr($Campo, 1, strlen($Campo)) . " >= " . "'" . $Valor . "'" ;
        }
        if (substr($Campo, 0, 1) == "<")
            $Condicion = $Condicion . "" . substr($Campo, 1, strlen($Campo)) . " <= " . "'" . $Valor . "'" ;

        if (substr($Campo, 0, 1) == "M")
            $Condicion = $Condicion . "month(" . substr($Campo, 1, strlen($Campo)) . ") = " . "'" . $Valor . "'";

        if (substr($Campo, 0, 1) == "A")
            $Condicion = $Condicion . "year(" . substr($Campo, 1, strlen($Campo)) . ") = " . "'" . $Valor . "'";

        if (substr($Campo, 0, 1) == "B")
            $Condicion = $Condicion . "" . substr($Campo, 1, strlen($Campo)) . " in (" . $Valor . ")";
        if (substr($Campo, 0, 1) == "Q") {
            $Condicion = $Condicion . " " . substr($Campo, 1, strlen($Campo)) . " BETWEEN " . "'" . $Valor . "' AND date_add(CONVERT('" . $Valor . "', DATE),INTERVAL +1 day);";
        }

        #retornamos $Valor
        return $Condicion;
    }
    public function papProductostock($f3)
    {
        $idusuario = is_null($f3->get('POST.idusuario')) ? 'T' : $f3->get('POST.idusuario');
        $llave = is_null($f3->get('POST.llave')) ? 'T' : $f3->get('POST.llave');
        if ($this->M_Usuariologueado->ValidaSession($idusuario, $llave, 'papProductostock')) {
            $Tipo = 'C';
            $idproductostock = is_null($f3->get('POST.pidproductostock')) ? 'T' : $f3->get('POST.pidproductostock');
            $idproducto = is_null($f3->get('POST.pidproducto')) ? 'T' : $f3->get('POST.pidproducto');
            $idsucursal = is_null($f3->get('POST.pidsucursal')) ? 'T' : $f3->get('POST.pidsucursal');
            $cantidad = is_null($f3->get('POST.pcantidad')) ? 'T' : $f3->get('POST.pcantidad');
            $cantidadminima = is_null($f3->get('POST.pcantidadminima')) ? 'T' : $f3->get('POST.pcantidadminima');
            $cantidadmaxima = is_null($f3->get('POST.pcantidadmaxima')) ? 'T' : $f3->get('POST.pcantidadmaxima');
            $preciocompra = is_null($f3->get('POST.ppreciocompra')) ? 'T' : $f3->get('POST.ppreciocompra');
            $precioventa = is_null($f3->get('POST.pprecioventa')) ? 'T' : $f3->get('POST.pprecioventa');
            $idusuarioregistra = is_null($f3->get('POST.pidusuarioregistra')) ? 'T' : $f3->get('POST.pidusuarioregistra');
            $idcompradetalle = is_null($f3->get('POST.pidcompradetalle')) ? 'T' : $f3->get('POST.pidcompradetalle');
            $idcompradetalledato = is_null($f3->get('POST.pidcompradetalledato')) ? 'T' : $f3->get('POST.pidcompradetalledato');
            $sql = "CALL papactualizastock('" . $Tipo . "','" . $idproductostock . "','" . $idproducto . "','" . $idsucursal . "','" . $cantidad . "','" . $cantidadminima . "','" . $cantidadmaxima . "','" . $preciocompra . "','" . $precioventa . "','" . $idusuarioregistra . "','" . $idcompradetalle . "','" . $idcompradetalledato . "'); ";
            try {
                $resulto = $f3->get('DB')->exec($sql);
                $items = array();
                $msg = 'add Productostock';
                $items = $resulto;
                echo json_encode([
                    'mesaje' => $msg,
                    'info' => [
                        'item' => $items
                    ]
                ]);
            } catch (PDOException $e) {
                echo json_encode('{"error" : { "text":' . $e->getMessage() . '}');
                $resulto = $f3->get('DB')->exec($sql);
                $items = array();
                $msg = 'Productostock registrada';
                $items = $resulto;
                echo json_encode([
                    'mesaje' => $msg,
                    'info' => [
                        'item' => $items
                    ]
                ]);
            } catch (PDOException $e) {
                echo json_encode('{"error" : { "text":' . $e->getMessage() . '}');
            }
        } else {
            $msg = 'llave no valida';
            $items = '';
            echo json_encode([
                'mesaje' => $msg,
                'info' => [
                    'item' => $items
                ]
            ]);
        }
    }
}
