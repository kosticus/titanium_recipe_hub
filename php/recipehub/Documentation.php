<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Category.php
 * GET
 *
 * 
 * 
 */

?>

<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            body { font-family: tahoma; font-size : 10pt; margin:0; padding:0; }
            div#content { padding:20px; }
            h1 { font-size:12pt; }
            /* description of the category */
            .desc { font-size:9pt; } 
            
            ul, li { list-style:none; margin-top:10px; }
            tr:nth-child(even) {background: #e2e2e2}
            tr:nth-child(odd) {background: #FFF}
            
            table { border-collapse: collapse; border: 1px solid #9eadc0 }
            tr.header { border:1px solid #9eadc0; background-color: #dee3e9; padding:10px; border-width:1px;  }
            th, td { padding:5px; text-align: left; }
            .obj-name { width : 125px; color: #4c6b87; font-weight:bold; }
            .obj-type { width : 150px; font-style:italic; }
            .obj-desc { width : 300px; }
            .obj-header { padding:4px;  font-weight: bold; width:150px;
                          border : solid 1px #d09d00; border-bottom: none;
                    background: #febf01; /* Old browsers */
                    background: -moz-linear-gradient(top,  #febf01 0%, #fce08a 99%); /* FF3.6+ */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#febf01), color-stop(99%,#fce08a)); /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top,  #febf01 0%,#fce08a 99%); /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(top,  #febf01 0%,#fce08a 99%); /* Opera 11.10+ */
            background: -ms-linear-gradient(top,  #febf01 0%,#fce08a 99%); /* IE10+ */
            background: linear-gradient(to bottom,  #febf01 0%,#fce08a 99%); /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#febf01', endColorstr='#fce08a',GradientType=0 ); /* IE6-9 */
            }
            
            tr.methods { background-color:white; border-top:solid 1px #9eadc0;   }
            tr.methods td { padding:10px; }
            div.request { margin-top:10px; border-top:solid 1px #9eadc0; font-size:8pt; }
            div.result { color: #4c6b87; font-weight:bold; }
            div.req-desc { color:gray; }
            span.method { font-weight:bold; }
            div.param span.type { color:Green; color: #4c6b87 }
        </style>

        <script type='text/javascript' src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js">
            
        </script>

        <!-- BUG REPORT -->
        <script type="text/javascript">
           
        </script>
    </head>
    <body>
        <div id='content'>
            
            
            
            <div>
                <h1>Documentation</h1>

                <div class="desc">
                    Objects that will be returned.

                    <!-- list of objects -->
                    <ul>
                        <li id='auth1-object'>
                            <div class="obj-header">Auth1 - Subclass of User</div>
                            <div>
                                <table>
                                    <tr class='header'>
                                        <th>name</th>
                                        <th>type</th>
                                        <th>description</th>
                                    </tr> 

                                    <tr>
                                        <td class='obj-name'>email</td>
                                        <td class='obj-type'>string</td>
                                        <td class='obj-desc'>email of the user</td>
                                    </tr>
                                    <tr>
                                        <td class='obj-name'>salt</td>
                                        <td class='obj-type'>string</td>
                                        <td class='obj-desc'>randomly generated string used to encrypt password</td>
                                    </tr>
                                    <tr>
                                        <td class='obj-name'>success</td>
                                        <td class='obj-type'>boolean</td>
                                        <td class='obj-desc'>displays whether the web service method was successful</td>
                                    </tr>
                                </table>
                            </div>
                        </li>

                        <li id='auth2-object'>
                            <div class="obj-header">Auth2 - Subclass of User</div>
                            <div>
                                <table>
                                    <tr class='header'>
                                        <th>name</th>
                                        <th>type</th>
                                        <th>description</th>
                                    </tr> 
                                    <tr>
                                        <td class='obj-name'>user_id</td>
                                        <td class='obj-type'>integer</td>
                                        <td class='obj-desc'>identifier of user object</td>
                                    </tr>
                                    <tr>
                                        <td class='obj-name'>email</td>
                                        <td class='obj-type'>string</td>
                                        <td class='obj-desc'>email of the user</td>
                                    </tr>
                                    <tr>
                                        <td class='obj-name'>success</td>
                                        <td class='obj-type'>boolean</td>
                                        <td class='obj-desc'>displays whether the web service method was successful</td>
                                    </tr>
                                </table>
                            </div>
                        </li>

                        <li id='category-object'>
                            <div class="obj-header">Category</div>
                            <div>
                                <table>
                                    <tr class='header'>
                                        <th>name</th>
                                        <th>type</th>
                                        <th>description</th>
                                    </tr> 
                                    <tr>
                                        <td class='obj-name'>category_id</td>
                                        <td class='obj-type'>integer</td>
                                        <td class='obj-desc'>identifier of category object</td>
                                    </tr>
                                    <tr>
                                        <td class='obj-name'>name</td>
                                        <td class='obj-type'>string</td>
                                        <td class='obj-desc'>name of category</td>
                                    </tr>
                                    <tr class="methods">
                                        <td colspan="3">
                                            <div class="request">
                                                <span class="method">GET</span>&nbsp;&nbsp;&nbsp;
                                                <span class="path">/Services/Category.php </span>
                                                <span class="param"></span>
                                                
                                                <div class="result">
                                                    returns 
                                                    Array&lt;Category&gt;
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </li>

                        <li id='ingredient-object'>
                            <div class="obj-header">Ingredient</div>
                            <div>
                                <table>
                                    <tr class='header'>
                                        <th>name</th>
                                        <th>type</th>
                                        <th>description</th>
                                    </tr> 
                                    <tr>
                                        <td class='obj-name'>recipe_item_ingredient_id</td>
                                        <td class='obj-type'>integer</td>
                                        <td class='obj-desc'>identifier of ingredient object</td>
                                    </tr>

                                    <tr>
                                        <td class='obj-name'>amount</td>
                                        <td class='obj-type'>string</td>
                                        <td class='obj-desc'>amount of the ingredient required</td>
                                    </tr>

                                    <tr>
                                        <td class='obj-name'>unit_id</td>
                                        <td class='obj-type'>integer</td>
                                        <td class='obj-desc'>identifier of the unit</td>
                                    </tr>

                                    <tr>
                                        <td class='obj-name'>unit_name_abbr</td>
                                        <td class='obj-type'>string</td>
                                        <td class='obj-desc'>name of the unit type (tsp, tbl, etc)</td>
                                    </tr>

                                    <tr>
                                        <td class='obj-name'>ingredient</td>
                                        <td class='obj-type'>string</td>
                                        <td class='obj-desc'>name of the ingredient</td>
                                    </tr>
                                </table>
                            </div>
                        </li>

                        <li id='instruction-object'>
                            <div class="obj-header">Instruction</div>
                            <div>
                                <table>
                                    <tr class='header'>
                                        <th>name</th>
                                        <th>type</th>
                                        <th>description</th>
                                    </tr> 
                                    <tr>
                                        <td class='obj-name'>recipe_id</td>
                                        <td class='obj-type'>integer</td>
                                        <td class='obj-desc'>id that references the recipe</td>
                                    </tr>

                                    <tr>
                                        <td class='obj-name'>instruction_index</td>
                                        <td class='obj-type'>integer</td>
                                        <td class='obj-desc'>order that the instruction should be displayed</td>
                                    </tr>

                                    <tr>
                                        <td class='obj-name'>instruction</td>
                                        <td class='obj-type'>string</td>
                                        <td class='obj-desc'>instruction/step for the recipe</td>
                                    </tr>

                                </table>
                            </div>
                        </li>

                        <li id='rating-object'>
                            <div class="obj-header">Rating</div>
                            <div>
                                <table>
                                    <tr class='header'>
                                        <th>name</th>
                                        <th>type</th>
                                        <th>description</th>
                                    </tr> 
                                    <tr>
                                        <td class='obj-name'>user_id</td>
                                        <td class='obj-type'>integer</td>
                                        <td class='obj-desc'>id of the user that rated this recipe</td>
                                    </tr>
                                    <tr>
                                        <td class='obj-name'>recipe_id</td>
                                        <td class='obj-type'>integer</td>
                                        <td class='obj-desc'>id of the recipe that was rated</td>
                                    </tr>
                                    <tr>
                                        <td class='obj-name'>rating</td>
                                        <td class='obj-type'>integer</td>
                                        <td class='obj-desc'>the rating given for the recipe (1-10)</td>
                                    </tr>
                                    
                                    <tr class="methods">
                                        <td colspan="3">
                                            <div class="request">
                                                <div class="req-desc">Get a list of all ratings the user has given</div>
                                                <span class="method">GET</span>&nbsp;&nbsp;&nbsp;
                                                <span class="path">/Services/Rating.php </span>
                                                <div class="param">@param <span class="param">user_id</span> <span class="type">integer</span></div>
                                                <div class="result">
                                                    returns 
                                                    Array&lt;Rating&gt;
                                                </div>
                                            </div>s
                                            
                                            <div class="request">
                                                <div class="req-desc">Insert/Update a new rating, if a rating already exists it will remove the old rating and add a new one.</div>
                                                <span class="method">POST</span>&nbsp;&nbsp;&nbsp;
                                                <span class="path">/Services/Rating.php </span>
                                                <div class="param">@param <span class="param">user_id</span> <span class="type">integer</span></div>
                                                <div class="param">@param <span class="param">rating</span> <span class="type">integer</span></div>
                                                <div class="param">@param <span class="param">recipe_id</span> <span class="type">integer</span></div>
                                                
                                                <div class="result">
                                                    returns 
                                                    RecipeRating
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </li>

                        <li id='reciperating-object'>
                            <div class="obj-header">RecipeRating</div>
                            <div>
                                <table>
                                    <tr class='header'>
                                        <th>name</th>
                                        <th>type</th>
                                        <th>description</th>
                                    </tr> 
                                    <tr>
                                        <td class='obj-name'>count</td>
                                        <td class='obj-type'>integer</td>
                                        <td class='obj-desc'>number of people that rated this recipe</td>
                                    </tr>
                                    <tr>
                                        <td class='obj-name'>avg</td>
                                        <td class='obj-type'>integer</td>
                                        <td class='obj-desc'>average rating of this reipce</td>
                                    </tr>


                                </table>
                            </div>
                        </li>              

                        <li id='recipe-object'>
                            <div class="obj-header">Recipe</div>
                            <div>
                                <table>
                                    <tr class='header'>
                                        <th>name</th>
                                        <th>type</th>
                                        <th>description</th>
                                    </tr> 
                                    <tr>
                                        <td class='obj-name'>recipe_id</td>
                                        <td class='obj-type'>integer</td>
                                        <td class='obj-desc'>identifier of recipe object</td>
                                    </tr>
                                    <tr>
                                        <td class='obj-name'>recipe_created_ts</td>
                                        <td class='obj-type'>timestamp</td>
                                        <td class='obj-desc'>date the recipe was created</td>
                                    </tr>
                                    <tr>
                                        <td class='obj-name'>recipe_updated_ts</td>
                                        <td class='obj-type'>timestamp</td>
                                        <td class='obj-desc'>date the recipe was last updated</td>
                                    </tr>
                                    <tr>
                                        <td class='obj-name'>title</td>
                                        <td class='obj-type'>string</td>
                                        <td class='obj-desc'>name of the recipe</td>
                                    </tr>
                                    <tr>
                                        <td class='obj-name'>description</td>
                                        <td class='obj-type'>string</td>
                                        <td class='obj-desc'>short description of the recipe</td>
                                    </tr>
                                    <tr>
                                        <td class='obj-name'>author_id</td>
                                        <td class='obj-type'>integer</td>
                                        <td class='obj-desc'>references the user object user_id</td>
                                    </tr>
                                    <tr>
                                        <td class='obj-name'>prep_time</td>
                                        <td class='obj-type'>integer</td>
                                        <td class='obj-desc'>amount of time it takes to prepare this recipe</td>
                                    </tr>
                                    <tr>
                                        <td class='obj-name'>cook_time</td>
                                        <td class='obj-type'>integer</td>
                                        <td class='obj-desc'>amount of time it takes to cook this recipe</td>
                                    </tr>
                                    <tr>
                                        <td class='obj-name'>serving_size</td>
                                        <td class='obj-type'>integer</td>
                                        <td class='obj-desc'>amount of people this recipe will serve</td>
                                    </tr>
                                    <tr>
                                        <td class='obj-name'>active</td>
                                        <td class='obj-type'>boolean</td>
                                        <td class='obj-desc'>is this recipe active, read-only</td>
                                    </tr>
                                    
                                    <tr class="methods">
                                        <td colspan="3">
                                            <div class="request">
                                                <div class="req-desc">Inserts a new recipe</div>
                                                <span class="method">POST</span>&nbsp;&nbsp;&nbsp;
                                                <span class="path">/Services/Recipe.php </span>
                                                <div class="param">@param <span class="param">title</span> <span class="type">string</span></div>
                                                <div class="param">@param <span class="param">description</span> <span class="type">string</span></div>
                                                <div class="param">@param <span class="param">author_id</span> <span class="type">integer</span></div>
                                                <div class="param">@param <span class="param">prep_time</span> <span class="type">integer</span></div>
                                                <div class="param">@param <span class="param">cook_time</span> <span class="type">integer</span></div>
                                                <div class="param">@param <span class="param">serving_size</span> <span class="type">integer</span></div>
                                                <div class="param">@param <span class="param">thumbnail</span> <span class="type">string</span></div>
                                                <div class="param">@param <span class="param">instructions</span> <span class="type">array&lt;Instruction&gt;</span></div>
                                                <div class="param">@param <span class="param">ingredients</span> <span class="type">array&lt;Ingredient&gt;</span></div>
                                                <div class="param">@param <span class="param">categories</span> <span class="type">array&lt;Category&gt;</span></div>
                                                
                                                <div class="result">
                                                    returns Recipe
                                                </div>
                                            </div>
                                            
                                            <div class="request">
                                                <div class="req-desc">Update a recipe</div>
                                                <span class="method">PUT</span>&nbsp;&nbsp;&nbsp;
                                                <span class="path">/Services/Recipe.php </span>
                                                <div class="param">@param <span class="param">recipe_id</span> <span class="type">integer</span></div>
                                                <div class="param">@param <span class="param">title</span> <span class="type">string</span></div>
                                                <div class="param">@param <span class="param">description</span> <span class="type">string</span></div>
                                                <div class="param">@param <span class="param">author_id</span> <span class="type">integer</span></div>
                                                <div class="param">@param <span class="param">prep_time</span> <span class="type">integer</span></div>
                                                <div class="param">@param <span class="param">cook_time</span> <span class="type">integer</span></div>
                                                <div class="param">@param <span class="param">serving_size</span> <span class="type">integer</span></div>
                                                <div class="param">@param <span class="param">thumbnail</span> <span class="type">string</span></div>
                                                <div class="param">@param <span class="param">instructions</span> <span class="type">array&lt;Instruction&gt;</span></div>
                                                <div class="param">@param <span class="param">ingredients</span> <span class="type">array&lt;Ingredient&gt;</span></div>
                                                <div class="param">@param <span class="param">categories</span> <span class="type">array&lt;Category&gt;</span></div>
                                                <div class="result">
                                                    returns Recipe
                                                </div>
                                            </div>
                                            
                                            <div class="request">
                                                <div class="req-desc">Get All Recipes</div>
                                                <span class="method">GET</span>&nbsp;&nbsp;&nbsp;
                                                <span class="path">/Services/Rating.php </span>
                                                <div class="param">@param <span class="param">search</span> <span class="type">string</span></div>
                                                <div class="param">@param <span class="param">filterBy</span> <span class="type">string</span></div>
                                                <div class="param">@param <span class="param">sortBy</span> <span class="type">string</span></div>
                                                <div class="param">@param <span class="param">limit</span> <span class="type">integer</span></div>
                                                <div class="param">@param <span class="param">offset</span> <span class="type">integer</span></div>
                                                <div class="param">@param <span class="param">user_id</span> <span class="type">integer</span></div>
                                                
                                                <div class="result">
                                                    returns 
                                                    Array&lt;Recipe&gt;
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                </table>
                            </div>
                        </li>

                        <li id='user-object'>
                            <div class="obj-header">User</div>
                            <div>
                                <table>
                                    <tr class='header'>
                                        <th>name</th>
                                        <th>type</th>
                                        <th>description</th>
                                    </tr> 
                                    <tr>
                                        <td class='obj-name'>user_id</td>
                                        <td class='obj-type'>integer</td>
                                        <td class='obj-desc'>identifier of user object</td>
                                    </tr>
                                    <tr>
                                        <td class='obj-name'>email</td>
                                        <td class='obj-type'>string</td>
                                        <td class='obj-desc'>email of the user, also used for their login</td>
                                    </tr>

                                    <tr>
                                        <td class='obj-name'>password_hash</td>
                                        <td class='obj-type'>string</td>
                                        <td class='obj-desc'>hash generated by app</td>
                                    </tr>

                                    <tr>
                                        <td class='obj-name'>password_salt</td>
                                        <td class='obj-type'>string</td>
                                        <td class='obj-desc'>randomly generated string used to encrypt password</td>
                                    </tr>

                                    <tr class="methods">
                                        <td colspan="3">
                                            <div class="request">
                                                <div class="req-desc">Inserts a new user, email and password are passed through basic auth</div>
                                                <span class="method">POST</span>&nbsp;&nbsp;&nbsp;
                                                <span class="path">/Services/User.php </span>
                                                <div class="param">@param <span class="param">email</span> <span class="type">string</span></div>
                                                <div class="param">@param <span class="param">password_salt</span> <span class="type">string</span></div>
                                                <div class="param">@param <span class="param">password_hash</span> <span class="type">string</span></div>
                                                <div class="result">
                                                    returns User
                                                </div>
                                            </div>
                                            
                                            <div class="request">
                                                <div class="req-desc">Updates the users salt and password</div>
                                                <span class="method">PUT</span>&nbsp;&nbsp;&nbsp;
                                                <span class="path">/Services/User.php </span>
                                                <div class="param">@param <span class="param">user_id</span> <span class="type">integer</span></div>
                                                <div class="param">@param <span class="param">email</span> <span class="type">string</span></div>
                                                <div class="param">@param <span class="param">password_hash</span> <span class="type">string</span></div>
                                                <div class="param">@param <span class="param">password_salt</span> <span class="type">string</span></div>
                                                <div class="result">
                                                    returns User
                                                </div>
                                            </div>
                                            
                                            <div class="request">
                                                <div class="req-desc">Gets the user by user_id</div>
                                                <span class="method">GET</span>&nbsp;&nbsp;&nbsp;
                                                <span class="path">/Services/User.php </span>
                                                <div class="param">@param <span class="param">user_id</span> <span class="type">integer</span></div>
                                                <div class="result">
                                                    returns 
                                                    User
                                                </div>
                                            </div>
                                            
                                            <div class="request">
                                                <div class="req-desc">Gets the user auth 1, this is used to update the users password</div>
                                                <span class="method">GET</span>&nbsp;&nbsp;&nbsp;
                                                <span class="path">/Services/User.php </span>
                                                <div class="param">@param <span class="param">auth</span> <span class="type">string</span></div>
                                                <div class="result">
                                                    returns 
                                                    Auth1
                                                </div>
                                            </div>
                                            
                                            <div class="request">
                                                <div class="req-desc">Gets the user auth 2, email and password are passed through basic auth</div>
                                                <span class="method">GET</span>&nbsp;&nbsp;&nbsp;
                                                <span class="path">/Services/User.php </span>
                                                <div class="param">@param <span class="param">email</span> <span class="type">string</span></div>
                                                <div class="param">@param <span class="param">password</span> <span class="type">string</span></div>
                                                
                                                <div class="result">
                                                    returns 
                                                    Auth2
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    
                                </table>
                            </div>
                        </li>

                    </ul>

                </div>
            </div>
    
        </div>
    </body>
</html>