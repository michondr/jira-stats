# jira issue statistics

usage:
`php fetch.php jira-company jira-user-email jira-api-token output-type`

1) jira company is in your url
2) email is your email
3) api token is in [generated in jira](https://id.atlassian.com/manage-profile/security/api-tokens) here: Account settings -> Security -> API token ->
   Create and manage API tokens -> Create API token
4) output type is `list`, `matrix`, `tsv`
    * list - json sprints with users and their issues
    * matrix - tsv where rows are sprints and columns are SP for person
    * tsv - tsv where rows are issues with info about each

if matrix or tsv is generated, copy it with `ctrl+c` and past with `ctrl+shift+v` to insert only values to google sheets