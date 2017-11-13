## Viable Versioner

Viable Versioner keeps your commits in a human-friendly format.
<p>
When deploying a commit, just call: 
[POST]/versions/create with the following params: </p>
<table>
    <tr>
        <td>commit_hash</td>    
        <td>string</td>    
        <td>required</td>    
    </tr>
    <tr>
        <td>repository</td>    
        <td>string</td>    
        <td>required</td>    
    </tr>
    <tr>
        <td>repository_version</td>    
        <td>string</td>    
        <td>optional</td>    
    </tr>
    <tr>
        <td>deployment_date</td>    
        <td>string (date_time format)</td>    
        <td>optional</td>    
    </tr>
</table>

If successful, it returns a version in the x.x.x format.

If a repository_version is sent in the request, a check for both version and repository will be made. 
If the repository_version is not already taken for that repository, it saves as it is, else, it's incremented and the correct version is saved and returned.

Accessing the base url in the browser, you can see the whole list of versions saved. 

By default, the route can be accessed by anyone, however, it can be restricted by enabling Laravel's Passport with php artisan passport:keys and adding the auth-api middleware to the route.

Clients for the api can be managed by uncommenting line #43 from layouts/app.blade.php.   

