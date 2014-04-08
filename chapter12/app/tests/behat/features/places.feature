Feature: Places

Scenario: Returning a collection of places
    When I request "GET /places"
    Then I get a "200" response
    And scope into the first "data" property
        And the properties exist:
            """
            id
            name
            lat
            lon
            address1
            address2
            city
            state
            zip
            website
            phone
            """
        And the "id" property is an integer

Scenario: Finding a specific place
    When I request "GET /places/1"
    Then I get a "200" response
    And scope into the "data" property
        And the properties exist:
            """
            id
            name
            lat
            lon
            address1
            address2
            city
            state
            zip
            website
            phone
            """
        And the "id" property is an integer