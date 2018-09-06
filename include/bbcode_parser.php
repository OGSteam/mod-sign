<?php
// note 
/// pk ne pas passer par un array
// la recherche est toujours la meme 
// seul le nb d arg change en fonction du bbcoe/fn utilisé
// is fn exist on balance ... 

class signcode_parser {
	protected $code = "";
	protected $img;

	protected $color = array();
	private $find = array();
	private $replace = array();


	protected $path_default="";
	protected $path_cache="";
	protected $path_ttf="";


	protected $cst_fond = array( '~\[fond\](.*?)\[/fond\]~s'  , '~\[fond=(\d*?),(\d*?)\]\[/fond\]~s' , '~\[fond=(\d*?),(\d*?)\]0\[/fond\]~s' );
	protected $cst_color = '~\[color=(\d*?),(\d*?),(\d*?)\]([[:alnum:]]*?)\[/color\]~s';
	protected $cst_colora = '~\[color=(\d*?),(\d*?),(\d*?),(\d*?)\]([[:alnum:]]*?)\[/color\]~s';
	protected $cst_line = '~\[line=(\d*?),(\d*?),(\d*?),(\d*?)\]([[:alnum:]]*?)\[/line\]~s';
	protected $cst_rectangle =array('~\[rectanglefilled=(\d*?),(\d*?),(\d*?),(\d*?),([[:alnum:]]*?)\]~s', '~\[rectangle=(\d*?),(\d*?),(\d*?),(\d*?),([[:alnum:]]*?)\]~s') ;
	protected $cst_ellipse =array('~\[ellipsefilled=(\d*?),(\d*?),(\d*?),(\d*?),([[:alnum:]]*?)\]~s', '~\[ellipse=(\d*?),(\d*?),(\d*?),(\d*?),([[:alnum:]]*?)\]~s') ;
	protected $cst_string =  '~\[string=(\d*?),(\d*?),(\d*?),([[:alnum:]]*?)\](.*?)\[/string\]~s';
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
		$this->get_ellipse();	// ajout des elipse /cercle
		$this->get_line();	// ajout des lignes
		$this->get_string();	// ajout des lignes



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




	private  function get_fond()
	{


		// on récupére le fond
		$matches = array();
		if 	(preg_match($this->cst_fond[0] ,  $this->code, $matches))
		{
			$path = $this->path_default.$matches[1] ;

				$this->img = @imagecreatefrompng($path);
                if(!$this->img) // en cas d erreur de chargement
                {
                    /* Création d'une image vide */
                    $this->img  = imagecreatetruecolor(500, 30);
                    $bgc = imagecolorallocate($this->img, 255, 255, 255);
                    $tc  = imagecolorallocate($this->img, 0, 0, 0);

                    imagefilledrectangle($this->img, 0, 0, 500, 30, $bgc);

                    /* On y affiche un message d'erreur */
                    imagestring($this->img, 1, 5, 5, 'Erreur de chargement ' . $path, $tc);



			}

		}
		elseif 	(preg_match($this->cst_fond[1] ,  $this->code, $matches)) // fond noir 
		{
			$this->img = imagecreatetruecolor( (int)$matches[1], (int)$matches[2] );
		
		}
		elseif 	(preg_match($this->cst_fond[2] ,  $this->code, $matches)) // fond transparent
		{
		    //var_dump($matches);
			$this->img = imagecreatetruecolor( (int)$matches[1], (int)$matches[2] );
			$color = imagecolorallocatealpha($this->img, 0, 0, 0, 127);
			imagefill($this->img, 0, 0, $color);
			imagesavealpha($this->img, true);
		}	// on a des reponses, nous allons donc stockers les variables qui vont biens
		
		else
		{
			echo "pas de fond on arrete la";
		}

	}


	// a revoir entierement .....
	private function get_degrade()
	{
		// on récupére le fond
		$matches = array();
		if 	(preg_match_all($this->cst_degrade ,  $this->code, $matches))
		{
			// on a des reponses, nous allons donc stockers les variables qui vont biens
			$total = count($matches[0]);

			for ($i = 0; $i < $total; $i++) {
				$this->degrade(10,10,51,90,'h',$this->color[$matches[6][$i]],$this->color[$matches[7][$i]]);

			}

		}

	}

	// on ajoute les lignes
	private  function get_line()
	{
		// on récupére le fond
		$matches = array();
		if 	(preg_match_all($this->cst_line ,  $this->code, $matches))
		{
			// on a des reponses, nous allons donc stockers les variables qui vont biens
			$total = count($matches[0]);

			for ($i = 0; $i < $total; $i++) {
				imageline ($this->img , $matches[1][$i] , $matches[2][$i] ,$matches[3][$i] , $matches[4][$i], $this->color[$matches[5][$i]] );
			}

		}

	}



private  function get_color()
	{
		// on récupére le fond
		$matches = array();
	if 	(preg_match_all($this->cst_color ,  $this->code, $matches))
		{
			// on a des reponses, nous allons donc stockers les variables qui vont biens
			$total = count($matches[0]);

			for ($i = 0; $i < $total; $i++) {
				$this->color[$matches[4][$i]] = imagecolorallocate($this->img, $matches[1][$i], $matches[2][$i], $matches[3][$i]);
			}
		}
		
		if 	(preg_match_all($this->cst_colora ,  $this->code, $matches))
		{
			// on a des reponses, nous allons donc stockers les variables qui vont biens
			$total = count($matches[0]);
		
			for ($i = 0; $i < $total; $i++) {
				$this->color[$matches[5][$i]] = imagecolorallocatealpha($this->img, $matches[1][$i], $matches[2][$i], $matches[3][$i], $matches[4][$i]);
			}
		}
		
		
		
		

	}
	
	private  function get_ellipse()
	{
		$matches = array();

		if 	(preg_match_all($this->cst_ellipse[0] ,  $this->code, $matches))
		{
			$total = count($matches[0]);

			for ($i = 0; $i < $total; $i++) {

				imagefilledellipse($this->img,  $matches[1][$i] , $matches[2][$i] ,$matches[3][$i] , $matches[4][$i], $this->color[$matches[5][$i]] );
			}


		}

		if 	(preg_match_all($this->cst_ellipse[1] ,  $this->code, $matches))
		{
			$total = count($matches[0]);

			for ($i = 0; $i < $total; $i++) {

				imageellipse($this->img,  $matches[1][$i] , $matches[2][$i] ,$matches[3][$i] , $matches[4][$i], $this->color[$matches[5][$i]] );
			}


		}
		
	
	}
	
	
	


	private  function convert_var()
	{
		// tout simplement
		$this->code =  str_replace($this->find,$this->replace,$this->code);


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
		
		$matches = array();

		if 	(preg_match_all($this->cst_rectangle[0] ,  $this->code, $matches))
		{
			// on a des reponses, nous allons donc stockers les variables qui vont biens
			$total = count($matches[0]);

			for ($i = 0; $i < $total; $i++) {

				imagefilledrectangle($this->img,  $matches[1][$i] , $matches[2][$i] ,$matches[3][$i] , $matches[4][$i], $this->color[$matches[5][$i]] );
			}


		}

		if 	(preg_match_all($this->cst_rectangle[1] ,  $this->code, $matches))
		{
			// on a des reponses, nous allons donc stockers les variables qui vont biens
			$total = count($matches[0]);

			for ($i = 0; $i < $total; $i++) {

				imagerectangle($this->img,  $matches[1][$i] , $matches[2][$i] ,$matches[3][$i] , $matches[4][$i], $this->color[$matches[5][$i]] );
			}


		}



	}



	// voir http://digitcodes.com/create-simple-php-bbcode-parser-function/
	// http://php.net/manual/fr/function.preg-match.php

	private function get_path()
	{
        $truepath = str_replace("/mod/sign/include" , "/mod/sign/" ,dirname(__FILE__));
        $truepath = str_replace("\mod\sign\include" , "\mod\sign\\" ,dirname(__FILE__)); //(si windows)
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