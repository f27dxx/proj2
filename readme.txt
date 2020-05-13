i'm using MAMP for mac. it has Apache, MySQL, PHP, phpMyAdmin built-in as a package. 
you will have to change the $username and $password matching your configuration in /config/Database.php

Some of the answer was included in doc/PROJ2.doc

Frederick Frederick0
uxboi thisisuxboI0
uxgurl thisisuxgurL0

There are rules to use the API:
1. Everyone can read recipe
2. Everyone can search recipe
2. Only logged in user can create recipe
3. Only user who own the recipe can UPDATE/DELETE the recipe (except admin, admin can UPDATE/DELETE any recipe regardless of ownership)
4. Only logged in user can post comment
5. Only user who own the recipe can DELETE the comment (except admin, admin can DELETE any comment regardless of ownership)
6. Access limit set to 1000 times in 24 hours and 1 time per second


Please import the sql file in doc/test_cocktailer.sql and name as cocktailer in database before running the test script collection
All the valid test script to fit the below scenario was tested in doc/Cocktailer test scripts.postman_collection.json (result was included in doc/PROJ2.doc)

The test script include the below scenario:
1. Non-logged in visitor read recipe -> 200
2. Non-logged in visitor create/update/delete recipe -> 401
3. Logged in user create/update / delete own recipe -> 200
4. Logged in user update/delete recipe don't belongs to him -> 403
5. Admin update/delete recipe don't belongs to him -> 200
6. Non-logged in user create/delete comment -> 401
7. Logged-in user create/delete own comment -> 200
8. Logged-in user delete comment don't belongs to him -> 403
9. Admin user delete comment don't belongs to him -> 200
10. Search with keyword to get a related recipe -> 200
11. Register a account -> 200
12. Login after register -> 200


////////////////////////////// If you want to see how functions works in my API /////////////////////////////
Create recipe : search `createRecipe` in models/Recipe.php and search case 'crecipe' in api/ws.php
Read recipe : search `getRecipe`, `getIngre`, `getStep`, `getComment` in models/Recipe.php and search case 'rrecipe' in api/ws.php
Update recipe : search `updateRecipe` in models/Recipe.php and search case 'urecipe' in api/ws.php
Delete recipe : search `deleteRecipe` in models/Recipe.php and search case 'drecipe' in api/ws.php

Create comment : search `createComment` in models/Recipe.php and search case 'ccomment' in api/ws.php
Read comment : search `getComment` in models/Recipe.php
Delete comment : search `deleteComment`in models/Recipe.php and search case 'dcomment' in api/ws.php

Register a account : search `createUser` in models/Recipe.php and search case 'register' in api/ws.php
Login : search `validateUser` in models/Recipe.php and search case 'login' in api/ws.php
Logout : search `case 'logout' in api/ws.php

Search for a related recipe : search `searchCocktail` in models/Recipe.php and search case 'search' in api/ws.php

Check comment ownership : search `checkCommentOwnership` in models/Recipe.php
Check recipe ownership : search `checkRecipeOwnership` in models/Recipe.php



////////////////////////////// If you want to manually react with database //////////////////////////////////

For login as a normal user : `http://localhost:8888/PROJ2/api/ws.php?method=login` 
{
	"username" : "b",
	"password" : "b"
}
For login as a admin user :`http://localhost:8888/PROJ2/api/ws.php?method=login` 
{
	"username" : "admin",
	"password" : "admin"
}

For read recipe : `http://localhost:8888/PROJ2/api/ws.php?method=rrecipe`
For create recipe : `http://localhost:8888/PROJ2/api/ws.php?method=crecipe`
{
	"name" : "test script 3 created by user b",
	"description" : "created 15 ingre and 5 step by user b",
	"imgUrl" : "https://via.placeholder.com/150",
	
    "quantity1" : "1",
    "measurement1" : "1",
    "item1" : "item 1",
    
    "quantity2" : "1",
    "measurement2" : "1",
    "item2" : "item 2",
    
    "quantity3" : "1",
    "measurement3" : "1",
    "item3" : "item 3",
    
    "quantity4" : "1",
    "measurement4" : "1",
    "item4": "item 4",
    
    "quantity5" : "5",
    "measurement5" : "1",
    "item5" : "item 5",
    
    "quantity6" : "6",
    "measurement6" : "1",
    "item6" : "item 6",
    
    "quantity7" : "7",
    "measurement7" : "1",
    "item7" : "item 7",
    
    "quantity8" : "8",
    "measurement8" : "1",
    "item8" : "item 8",
    
    "quantity9" : "9",
    "measurement9" : "1",
    "item9" : "item 9",
    
    "quantity10" : "10",
    "measurement10" : "1",
    "item10" : "item 10",
    
    "quantity11" : "11",
    "measurement11" : "1",
    "item11" : "item 11",
    
    "quantity12" : "12",
    "measurement12" : "1",
	"item12" : "item 12",
	
    "quantity13" : "13",
    "measurement13" : "1",
    "item13" : "item 13",
    
    "quantity14" : "14",
    "measurement14" : "1",
    "item14" : "item 14",
    
    "quantity15" : "15",
    "measurement15" : "1",
    "item15" : "item 15",
    
    "step1" : "step1 by user b",
    "step2" : "step2 by user b",
    "step3" : "step3 by user b",
    "step4" : "step4 by user b",
    "step5" : "step5 by user b"

}

For update recipe : `http://localhost:8888/PROJ2/api/ws.php?method=urecipe&id={recipe_id of the recipe}`
{
	"name" : "updated test script 3 created by user b",
	"description" : "created 15 ingre and 5 step by user b",
	"imgUrl" : "https://via.placeholder.com/150",
	"i_id1" : "279",
    "quantity1" : "1",
    "measurement1" : "1",
    "item1" : "updated item 1",
    "i_id2" : "280",
    "quantity2" : "1",
    "measurement2" : "1",
    "item2" : "updated item 2",
    "i_id3" : "281",
    "quantity3" : "1",
    "measurement3" : "1",
    "item3" : "updated item 3",
    "i_id4" : "282",
    "quantity4" : "1",
    "measurement4" : "1",
    "item4": "updated item 4",
    "i_id5" : "283",
    "quantity5" : "5",
    "measurement5" : "1",
    "item5" : "updated item 5",
    "i_id6" : "284",
    "quantity6" : "6",
    "measurement6" : "1",
    "item6" : "updated item 6",
    "i_id7" : "285",
    "quantity7" : "7",
    "measurement7" : "1",
    "item7" : "updated item 7",
    "i_id8" : "286",
    "quantity8" : "8",
    "measurement8" : "1",
    "item8" : "updated item 8",
    "i_id9" : "287",
    "quantity9" : "9",
    "measurement9" : "1",
    "item9" : "updated item 9",
    "i_id10" : "288",
    "quantity10" : "10",
    "measurement10" : "1",
    "item10" : "updated item 10",
    "i_id11" : "289",
    "quantity11" : "11",
    "measurement11" : "1",
    "item11" : "updated item 11",
    "i_id12" : "290",
    "quantity12" : "12",
    "measurement12" : "1",
	"item12" : "updated item 12",
	"i_id13" : "291",
    "quantity13" : "13",
    "measurement13" : "1",
    "item13" : "updated item 13",
    "i_id14" : "292",
    "quantity14" : "14",
    "measurement14" : "1",
    "item14" : "updated item 14",
    "i_id15" : "293",
    "quantity15" : "15",
    "measurement15" : "1",
    "item15" : "updated item 15",
    "met_id1" : "71",
    "step1" : "updated step1 by user b",
    "met_id2" : "72",
    "step2" : "updated step2 by user b",
    "met_id3" : "73",
    "step3" : "updated step3 by user b",
    "met_id4" : "74",
    "step4" : "updated step4 by user b",
    "met_id5" : "75",
    "step5" : "updated step5 by user b"

}
For delete recipe: `http://localhost:8888/PROJ2/api/ws.php?method=drecipe&id={recipe_id of recipe}`
For create comment: `http://localhost:8888/PROJ2/api/ws.php?method=ccomment&id={recipe_id of recipe}`
{
	"content" : "comment created by user b"
}
For delete comment: `http://localhost:8888/PROJ2/api/ws.php?method=dcomment&id={recipe_id}`
{
	"c_id" : "{you will need to find your c_id in comment table}"
}
For search recipe : `http://localhost:8888/PROJ2/api/ws.php?method=search&searchfield=vodka`
