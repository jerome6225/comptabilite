<?php

	class CategoryMovement{

		public function __construct(){}

		public static function getCategoriesMovement()
		{
			return Db::select('category_movement', '*', '', false);
		}

		public static function getNameCategoryMovement($idCategory)
		{
			return Db::select('category_movement', 'name_category_movement', array('id_category_movement' =>  array(PDO::PARAM_INT => $idCategory)));
		}
	}