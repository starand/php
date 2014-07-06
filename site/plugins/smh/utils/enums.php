<?
	abstract class CMD
	{
		const KitchenLightOn 	= 0;
		const KitchenLightOff 	= 1;
		const BathroomLightOn 	= 2;
		const BathroomLightOff 	= 3;
		const ToiletLightOn 	= 4;
		const ToiletLightOff 	= 5;
		const CorridorLightOn 	= 6;
		const CorridorLightOff 	= 7;
		const HallLightOn 		= 8;
		const HallLightOff 		= 9;
		const LightStatuses 	= 10;
		const ButtonStatuses 	= 11;
		const NightLightOn 		= 12;
		const NightLightOff 	= 13;
	}

	abstract class EBUTTONBITS
	{
		const EBB_KITCHEN 	= 1;
		const EBB_BATHROOM 	= 2;
		const EBB_TOILET	= 4;
		const EBB_CORRIDOR	= 8;
		const EBB_HALL 		= 16;
		const EBB_LAMP		= 32;
	};

	abstract class EROOMS
	{
		const KITCHEN 	= 0;
		const BATHROOM 	= 1;
		const TOILET	= 2;
		const CORRIDOR	= 3;
		const HALL 		= 4;
		const LAMP		= 5;
	};

?>