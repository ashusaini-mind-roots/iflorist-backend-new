app.controller('masterOverviewController', function($scope,$http,$localStorage,API_URL,$window) {

    console.log('masteroverview.js load success');

    $scope.storesList = [];
    $scope.selectedStoreItem = 1;

    $scope.yearsList = [];
    $scope.selectedYearsItem = "2018";

    $scope.weeks = [];

    $scope.avgActual = 0.00;
    $scope.avgTarget = 0.00;
    $scope.avgDifference = 0.00;

    $scope.getStores = function () {
        if($localStorage.currentUser) {
            $http({
                method: 'GET',
                url: API_URL + 'store/all/' + $localStorage.currentUser.user.id + '/' + $localStorage.currentUser.user.role_name ,
            }).then(
                function successCallback(response) {
                    $scope.storesList = response.data.stores;
                }
            );
        }
    }

    $scope.getYears = function () {
        $scope.yearsList = ["2017","2018","2019"];
    }

    $scope.getMasterOverviewWeekly = function () {
        if($localStorage.currentUser) {
            $http({
                method: 'GET',
                url: API_URL + 'master_overview_weekly/master_overview_weekly_of_fresh/' + $scope.selectedStoreItem + '/' + $scope.selectedYearsItem ,
            }).then(
                function successCallback(response) {
                    $scope.weeks = response.data.master_overview_weekly;
                    $scope.calcAVGs($scope.weeks);
                    console.log(response);
                }
            );
        }
    }

    $scope.getOverviewDataFromServer = function () {
        $scope.getMasterOverviewWeekly();
    }

    $scope.goToweekControlPage = function (week_id) {
        $localStorage.weekOverview = {
            selectedStoreId : $scope.selectedStoreItem,
            selectedYear : $scope.selectedYearsItem,
            selectedWeekId : week_id
        };
        $localStorage.weekOverview

        $window.location.href = "/weekpanel";
    }

    $scope.calcAVGs = function (master_overview_weekly) {
        var sum = 0;
        $scope.avgActual = 0.00;
        $scope.avgTarget = 0.00;
        $scope.avgDifference = 0.00;
        var count = master_overview_weekly.length;
        for (var i = 0; i < count; i++) {
            $scope.avgActual = $scope.avgActual + parseFloat(master_overview_weekly[i].actual);
            $scope.avgTarget = $scope.avgTarget +parseFloat( master_overview_weekly[i].target);
            $scope.avgDifference = $scope.avgDifference + parseFloat(master_overview_weekly[i].difference);
        }

        console.log($scope.avgActual);
        console.log($scope.avgTarget);
        console.log($scope.avgDifference);

        $scope.avgActual = $scope.avgActual / count;
        $scope.avgTarget = $scope.avgTarget / count;
        $scope.avgDifference = $scope.avgDifference / count;


    }

    $scope.getStores();
    $scope.getYears();
    $scope.getMasterOverviewWeekly();
});