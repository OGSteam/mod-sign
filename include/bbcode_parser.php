<?php
class signcode_parser {
	protected $code = "";
	protected $img;

	protected $color = array();
	private $find = array();
	private $replace = array();
	

	protected $path_default="";
	protected $path_cache="";
	protected $path_ttf="";


	protected $cst_fond = array( '~\[fond\](.*?)\[/fond\]~s'  , '~\[fond=(\d*?),(\d*?)\]\[/fond\]~s' );
	protected $cst_color = '~\[color=(\d*?),(\d*?),(\d*?)\]([[:alnum:]]*?)\[/color\]~s';
	protected $cst_line = '~\[line=(\d*?),(\d*?),(\d*?),(\d*?)\]([[:alnum:]]*?)\[/line\]~s';
	protected $cst_rectangle =array('~\[rectanglefilled=(\d*?),(\d*?),(\d*?),(\d*?),([[:alnum:]]*?)\]~s', '~\[rectangle=(\d*?),(\d*?),(\d*?),(\d*?),([[:alnum:]]*?)\]~s') ;
	protected $cst_string = '~\[string=(\d*?),(\d*?),(\d*?),([[:alnum:]]*?)\](.*?)\[/string\]~s';
	protected $cst_stringeffect = '~\[stringeffect=(\d*?),(\d*?),(\d*?),([[:alnum:]]*?),([[:alnum:]]*?),(\d*?)\](.*?)\[/stringeffect\]~s';
	protected $cst_var = '~\[var=([[:alnum:]]{3,10}),([[:alnum:]]{4,7}),(\d*?)\]~s';
	



	function __construct($code) {

		$this->code= $code;
		$this->get_path();

	}
	public function get_img()
	{
		return $this->img;
	}

	public function run()
	{
		$this->convert_var();
		$this->get_fond(); // récuperation de l image ( retourne seulement la premeire balise fond trouvé
		$this->get_color(); // récuperation des valiable des couleurs et stockage
		$this->get_rectangle();	// ajout des lignes
		$this->get_line();	// ajout des lignes
		$this->get_string();	// ajout des lignes




		//var_dump($this);

		//	$font_color = imagecolorallocate($this->img, 0, 255, 0);
		//	$stroke_color = imagecolorallocate($this->img, 255, 0, 0);
		//imagettfstroketext($img, 10, 0, 10, 50, $font_color, $stroke_color, "abstract.ttf", "Hello, World!", 2);
		//		$this->imagettfstroketext(20, 0, 10, 50, $font_color, $stroke_color, 	$this->path_ttf."arial.ttf", "H e l l o  ,  W o r l d !", 1);


		//	$this->image_string_contour(2, 30,30,"test 2", $font_color,$stroke_color,1);
		//	$this->image_string_contour(4, 200,70,"test 4", $font_color,$stroke_color,2);
		//	$this->image_string_contour(4, 51,51,"test 3", $stroke_color);
		//	$this->image_string_contour(4, 50,50,"test 3", $font_color);


		//$tmp_txt = explode(PHP_EOL, $this->code);
		// foreach ( $tmp_txt as $txt)
		//	{
		//		read_BBcode($txt);
		//	}
	}

	public function affiche()
	{
	header('Content-Type: image/png');
		imagepng($this->img);
		imagedestroy($this->img); // on libere ...


	}

	public function  set_value($var)
	{
		foreach($var as $key => $value)
		{
			
			$this->find[] = "[var=".$key."]";
			$this->replace[] = $value;
						
		}
	}



	public function read_BBcode($txt)
	{
		//le fond choisi pour la signature
		//	$image = imagecreatefrompng($nom_fond);
	}



	private  function get_fond()
	{
		// on récupére le fond
		$matches = array();
		if 	(preg_match($this->cst_fond[0] ,  $this->code, $matches))
		{
			$path = $this->path_default.$matches[1] ;
			if (file_exists($path))
			{
				$this->img = imagecreatefrompng($path);
			}

		}
		elseif 	(preg_match($this->cst_fond[1] ,  $this->code, $matches))
		{
			$this->img = imagecreatetruecolor( (int)$matches[1], (int)$matches[2] );

		}
		else
		{
			echo "pas de fond on arrete la";
		}

	}


	// on ajoute les lignes
	private  function get_line()
	{
		// on récupére le fond
		$matches = array();
		if 	(preg_match_all($this->cst_line ,  $this->code, $matches))
		{
			//	var_dump($matches);
			// on a des reponses, nous allons donc stockers les variables qui vont biens
			$total = count($matches[0]);

			for ($i = 0; $i < $total; $i++) {
				imageline ($this->img , $matches[1][$i] , $matches[2][$i] ,$matches[3][$i] , $matches[4][$i], $this->color[$matches[5][$i]] );
			}
			//	var_dump($matches);


		}

	}



	private  function get_color()
	{
		// on récupére le fond
		$matches = array();
		if 	(preg_match_all($this->cst_color ,  $this->code, $matches))
		{
			//	var_dump($matches);
			// on a des reponses, nous allons donc stockers les variables qui vont biens
			$total = count($matches[0]);

			for ($i = 0; $i < $total; $i++) {
				$this->color[$matches[4][$i]] = imagecolorallocate($this->img, $matches[1][$i], $matches[2][$i], $matches[3][$i]);
			}


		}

	}


private  function convert_var()
	{
	//	var_dump($this->find);
		//var_dump($this->replace);
		// tout simplement
		$this->code =  str_replace($this->find,$this->replace,$this->code);
		
		
		
		
		
		
		
		
		
		
		// on récupére le fond
		//$matches = array();
		//$types = array("player");
		
		//	foreach($types as $type)
		//	{
		//					$pattern =  str_replace("var", "player", $this->cst_var) ; 
		//	if 	(preg_match_all($pattern ,  $this->code, $matches))
		//	{
				// on a des reponses, nous allons donc stockers les variables qui vont biens
		//		$total = count($matches[0]);
			//	for ($i = 0; $i < $total; $i++) {
					//var_dump($this->$type[$matches[1][$i]][$matches[2][$i]]);
			//		if (isset($this->var[$type][$matches[1][$i]][$matches[2][$i]][$matches[3][$i]]))
			//		{
						// mal de tete
			//			$search = "[player=".$matches[1][$i].",".$matches[2][$i].",".$matches[3][$i]."]";
			//			$replace = $this->var[$type][$matches[1][$i]][$matches[2][$i]][$matches[3][$i]];
			//			 $this->code = str_replace($search, $replace, $this->code);
			//		}
					//var_dump($this->$type);
					//var_dump($this->$type["date"][0]);
					
		
			//	}
					//for ($i = 0; $i < $total; $i++) {
				//	$this->color[$matches[4][$i]] = imagecolorallocate($this->img, $matches[1][$i], $matches[2][$i], $matches[3][$i]);
				//}
			
		//
			//}
			
		//	}	

		
		
		
	}
	
	
	
	
	private  function get_string()
	{
		// on récupére le fond
		$matches = array();
		if 	(preg_match_all($this->cst_string ,  $this->code, $matches))
		{
			//	var_dump($matches);
			// on a des reponses, nous allons donc stockers les variables qui vont biens
			$total = count($matches[0]);

			for ($i = 0; $i < $total; $i++) {

				$this->image_string_contour( $matches[1][$i],  $matches[2][$i], $matches[3][$i], $matches[5][$i],  $this->color[$matches[4][$i]]);
				//	var_dump($matches);
			}


		}



		$matches = array();
		if 	(preg_match_all($this->cst_stringeffect ,  $this->code, $matches))
		{
			//	var_dump($matches);
			// on a des reponses, nous allons donc stockers les variables qui vont biens
			$total = count($matches[0]);

			for ($i = 0; $i < $total; $i++) {

				$this->image_string_contour( $matches[1][$i],  $matches[2][$i], $matches[3][$i], $matches[7][$i],  $this->color[$matches[4][$i]], $this->color[$matches[5][$i]] , $matches[6][$i]);
				//	var_dump($matches);
			}


		}



			



	}

	private  function get_rectangle()
	{
		// on récupére le fond
		$matches = array();

		if 	(preg_match_all($this->cst_rectangle[0] ,  $this->code, $matches))
		{
			//	var_dump($matches);
			// on a des reponses, nous allons donc stockers les variables qui vont biens
			$total = count($matches[0]);

			for ($i = 0; $i < $total; $i++) {

				imagefilledrectangle($this->img,  $matches[1][$i] , $matches[2][$i] ,$matches[3][$i] , $matches[4][$i], $this->color[$matches[5][$i]] );
				//var_dump($matches);
			}


		}

		if 	(preg_match_all($this->cst_rectangle[1] ,  $this->code, $matches))
		{
			//	var_dump($matches);
			// on a des reponses, nous allons donc stockers les variables qui vont biens
			$total = count($matches[0]);

			for ($i = 0; $i < $total; $i++) {

				imagerectangle($this->img,  $matches[1][$i] , $matches[2][$i] ,$matches[3][$i] , $matches[4][$i], $this->color[$matches[5][$i]] );
				//	var_dump($matches);
			}


		}



	}



	// voir http://digitcodes.com/create-simple-php-bbcode-parser-function/
	// http://php.net/manual/fr/function.preg-match.php

	private function get_path()
	{
		$truepath = str_replace("/mod/sign/include" , "/mod/sign/" ,dirname(__FILE__));
		$this->path_cache = $truepath."fond/cache/";
		$this->path_default = $truepath."fond/default/";
		$this->path_ttf = $truepath."ttf/"; /// a suivre pour cette soluce

			
	}

	function imagettfstroketext( $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) {

		for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
			for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
			$bg = imagettftext($this->img, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);

	}


	/**
	 * cf ogsign origin /TODO alternative ttf ????
	 * Fonction pour la génération des signatures
	 * Dessine le texte, en fonction des tableaux donnés (qui permettent l'ombrage et/ou le détourage)
	 * Si aucun tableau n'est donné, pas d'ombrage/détourage
	 *
	 * @param int $font
	 * @param int $x_cord
	 * @param int $y_cord
	 * @param string $text
	 * @param int $color_text
	 * @param int $color_contour
	 * @param in type

	 */
	function image_string_contour( $font, $x_cord, $y_cord, $text, $color_text, $color_contour = NULL, $type = 0)
	{
		if (isset($color_contour) & ($type != 0)){

			// positions pour le contour
			if ($type == 1) {
				$_x = array(8, 1, 0, 1, -1, -1, 1, 0, -1);
				$_y = array(8, 0, -1, -1, 0, -1, 1, 1, 1);
			}
			elseif ($type == 2)
			{
				$_x = array(1, 1);
				$_y = array(1, 1);
			}
			else
			{
				$_x = array();
				$_y = array();
					
			}
			// dessin du contour du texte
			// les tableaux $_x et $_y contiennent en position [0] le nombre d'éléments (pour éviter de le recalculer ici à chaque appel)
			for($n=1;$n<=$_x[0];$n++) {
				imagestring($this->img, $font, $x_cord+$_x[$n], $y_cord+$_y[$n], $text, $color_contour);
			}
		}
		// écriture du texte
		imagestring($this->img, $font, $x_cord, $y_cord, $text, $color_text);

	}


}