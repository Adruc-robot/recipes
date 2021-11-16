$(document).ready(function() {
	//set up the buttons
	$('#recSave').on('click', function() {
		$("#recSave").attr("disabled", "disabled");
		var theButton = document.getElementById("recSave");
		var name = $('#recName').val();
		var tablename = $('#recTableName').val();
		$.ajax({
			url: "includes/recipes.inc.php",
			type: "POST",
			data: {
				name: name,
				tablename: tablename
			},
			cache: false,
			success: function(dataResult){
				errorState = validateResult(dataResult);
				//console.log("errorState after write, but still in ajax: " + errorState);
				if (!errorState) {
					theButton.disabled = false;

					//do another ajax and get the recipe #
					$.ajax({
						url: "includes/shagger.inc.php",
						type: "GET",
						data: {
							name: name,
							tablename: tablename
						},
						cache: false,
						success: function(dataResult){
							errorState = validateResult(dataResult);

							var dataResult = JSON.parse(dataResult);
							recipeNumber = dataResult.theKey;
							setRecipe(recipeNumber,name);
							recipeSummary("recipe",name);
						}
					});
				}
			}
		});
	});

	$('#recIngSave').on('click', function() {
		$("#recIngSave").attr("disabled", "disabled");
		var theButton = document.getElementById("recIngSave");
		var recipe = $('#recIngRecipe').val();
		var ingredient = $('#recIngIngredient').val();
		var amount = $('#recIngAmount').val();
		var unit = $('#recIngUnit').val();
		var prep_instructions = $('#recIngPrep').val();
		var tablename = $('#recIngTableName').val();
		$.ajax({
			url: "includes/recipe_ingredients.inc.php",
			type: "POST",
			data: {
				RECIPE: recipe,
				INGREDIENT: ingredient,
				AMOUNT: amount,
				UNIT: unit,
				PREP_INSTRUCTIONS: prep_instructions,
				tablename: tablename
			},
			cache: false,
			success: function(dataResult){
				errorState = validateResult(dataResult);
				console.log(errorState);
				if (!errorState) {
					theButton.disabled = false;
					dataSet = amount + " " + $('#recIngUnit :selected').text() + " " + $('#recIngIngredient :selected').text() + " " + prep_instructions;
					recipeSummary("recipe_ingredients",dataSet);
				}
			}
		});
	});

	$('#recStepSave').on('click', function() {
		$("#recStepSave").attr("disabled", "disabled");
		var theButton = document.getElementById("recStepSave");
		//theButton.disabled = true;
		var recipe = $('#recStepRecipe').val();
		var step_number = $('#recStepNumber').val();
		var step_text = $('#recStepStepTxt').val();
		var tablename = $('#recStepTableName').val();
		$.ajax({
			url: "includes/recipe_steps.inc.php",
			type: "POST",
			data: {
				recipe: recipe,
				step_number: step_number,
				step_text: step_text,
				tablename: tablename
			},
			cache: false,
			success: function(dataResult){
				errorState = validateResult(dataResult);
				if (!errorState) {
					theButton.disabled = false;
					dataSet = step_number + ". " + step_text;
					recipeSummary("recipe_steps",dataSet);
				}
			}
		});
	});

	!(function(d){
	var itemClassName = "carousel__item";
    items = d.getElementsByClassName(itemClassName);
    totalItems = items.length;
    slide = 0;
	moving = true;
	
	// Set classes
	function setInitialClasses() {
		// Targets the previous, current, and next items
		// This assumes there are at least three items.
		items[totalItems - 1].classList.add("prev");
		items[0].classList.add("active");
		items[1].classList.add("next");
	}
  	// Set event listeners
	function setEventListeners() {
		var next = d.getElementsByClassName('carousel__button--next')[0],
			prev = d.getElementsByClassName('carousel__button--prev')[0];
		next.addEventListener('click', moveNext);
		prev.addEventListener('click', movePrev);
	}
	// Next navigation handler
	function moveNext() {
		console.log("moveNext");
		// Check if moving
		if (!moving) {
		// If it's the last slide, reset to 0, else +1
		if (slide === (totalItems - 1)) {
			slide = 0;
		} else {
			slide++;
		}
		// Move carousel to updated slide
		moveCarouselTo(slide);
		}
	}
  	// Previous navigation handler
	function movePrev() {
		console.log ("movePrev");
		// Check if moving
		if (!moving) {
		// If it's the first slide, set as the last slide, else -1
		if (slide === 0) {
			slide = (totalItems - 1);
		} else {
			slide--;
		}
				
		// Move carousel to updated slide
		moveCarouselTo(slide);
		}
	}
	function disableInteraction() {
		// Set 'moving' to true for the same duration as our transition.
		// (0.5s = 500ms)
		moving = true;
		// setTimeout runs its function once after the given time
		setTimeout(function(){
		  moving = false
		}, 500);
	}
	function moveCarouselTo(slide) {
		console.log("moveCarouelTo: " + slide);
		console.log(moving);
		// Check if carousel is moving, if not, allow interaction
		if(!moving) {
			// temporarily disable interactivity
			disableInteraction();

			switch(slide) {
				case 0:
					//this is recipe
					items[0].className = "input_region " + itemClassName + " active";
					items[1].className = "input_region " + itemClassName;
					items[2].className = "input_region " + itemClassName;
					break;
				case 1:
					//this is recipe_ingredients
					items[0].className = "input_region " + itemClassName;
					items[1].className = "input_region " + itemClassName + " active";
					items[2].className = "input_region " + itemClassName;
					break;
				case 2:
					//this is recipe_steps
					items[0].className = "input_region " + itemClassName;
					items[1].className = "input_region " + itemClassName;
					items[2].className = "input_region " + itemClassName + " active";
					break;
				default:
					//alls good
			}
		}
	}
	function initCarousel() {
		setInitialClasses();
		setEventListeners();
		// Set moving to false so that the carousel becomes interactive
		moving = false;
	}

	initCarousel();
}(document));

});
function validateResult(dataResult) {
	console.log(dataResult);
	var dataResult = JSON.parse(dataResult);
	var errorState = true;
	switch(dataResult.statusCode) {
		case 101:
			// getting constraints failed
			errorMessage = "Getting constraints query failed";
			break;
		case 102:
			// constraint query failed
			errorMessage = "Contraint query failed";
			break;
		case 103:
			//Constraint violated
			errorMessage = "Constraint violated";
			break;
		case 104:
			//Write failed
			errorMessage = "Write failed";
			break;
		default:
			errorMessage = "";
			errorState = false;
			//alls good
	}
	if (errorState) {
		alert(errorMessage);
		return errorState;
	} else {
		return errorState;
	}
}
function setRecipe(recipeNumber,recipeName) {

    var elements = document.getElementsByClassName("recipe_holder");
    for (i=0; i < elements.length; i++) {
        elements[i].value = recipeNumber;
    }
	document.getElementById("recipe_name").innerText = recipeName;
}

function recipeSummary(origin,dataSet) {
	switch (origin) {
		case "recipe":
			//this should only happen once
			document.getElementById("theTitle").innerText = dataSet;
			break;
		case "recipe_ingredients":
			//this happens multiple times
			document.getElementById("theIngredients").innerText = document.getElementById("theIngredients").innerText + dataSet + "\n";
			break;
		case "recipe_steps":
			//this happens multiple times
			document.getElementById("theSteps").innerText = document.getElementById("theSteps").innerText + dataSet + "\n";
			break;
		default:
			//nothing
			break;
	}
}