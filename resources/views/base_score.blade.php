@extends('web')

@section('title')
    BASE STRENGTH TABLE
@endsection

@section('content')
    <div class="row">
        <p class="col-xs-4 text-info">Base Strength (or base score) is a value used by the game in matchmaking. This table shows how much each building of each level contributes to your base strength value.</p>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <table class="table table-striped table-bordered table-hover header-fixed">
                <thead>
                <tr>
                    <th title="">Building</th>
                    <th title="">Level</th>
                    <th title="">Score</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Barracks</td>
                    <td>2</td>
                    <td>3</td>
                </tr>
                <tr class="odd">
                    <td>Barracks</td>
                    <td>3</td>
                    <td>4</td>
                </tr>
                <tr>
                    <td>Barracks</td>
                    <td>4</td>
                    <td>5</td>
                </tr>
                <tr class="odd">
                    <td>Barracks</td>
                    <td>5</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>Barracks</td>
                    <td>6</td>
                    <td>7</td>
                </tr>
                <tr class="odd">
                    <td>Barracks</td>
                    <td>7</td>
                    <td>8</td>
                </tr>
                <tr>
                    <td>Barracks</td>
                    <td>8</td>
                    <td>9</td>
                </tr>
                <tr class="odd">
                    <td>Barracks</td>
                    <td>9</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>Barracks</td>
                    <td>10</td>
                    <td>11</td>
                </tr>
                <tr class="odd">
                    <td>BurstTurret</td>
                    <td>2</td>
                    <td>30</td>
                </tr>
                <tr>
                    <td>BurstTurret</td>
                    <td>3</td>
                    <td>35</td>
                </tr>
                <tr class="odd">
                    <td>BurstTurret</td>
                    <td>4</td>
                    <td>40</td>
                </tr>
                <tr>
                    <td>BurstTurret</td>
                    <td>5</td>
                    <td>45</td>
                </tr>
                <tr class="odd">
                    <td>BurstTurret</td>
                    <td>6</td>
                    <td>50</td>
                </tr>
                <tr>
                    <td>BurstTurret</td>
                    <td>7</td>
                    <td>55</td>
                </tr>
                <tr class="odd">
                    <td>BurstTurret</td>
                    <td>8</td>
                    <td>60</td>
                </tr>
                <tr>
                    <td>BurstTurret</td>
                    <td>9</td>
                    <td>65</td>
                </tr>
                <tr class="odd">
                    <td>BurstTurret</td>
                    <td>10</td>
                    <td>70</td>
                </tr>
                <tr>
                    <td>ContrabandCantina</td>
                    <td>2</td>
                    <td>3</td>
                </tr>
                <tr class="odd">
                    <td>ContrabandCantina</td>
                    <td>3</td>
                    <td>4</td>
                </tr>
                <tr>
                    <td>ContrabandCantina</td>
                    <td>4</td>
                    <td>5</td>
                </tr>
                <tr class="odd">
                    <td>ContrabandCantina</td>
                    <td>5</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>ContrabandCantina</td>
                    <td>6</td>
                    <td>7</td>
                </tr>
                <tr class="odd">
                    <td>ContrabandCantina</td>
                    <td>7</td>
                    <td>8</td>
                </tr>
                <tr>
                    <td>ContrabandCantina</td>
                    <td>8</td>
                    <td>9</td>
                </tr>
                <tr class="odd">
                    <td>ContrabandCantinaLocked</td>
                    <td>9</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>ContrabandCantinaLocked</td>
                    <td>10</td>
                    <td>11</td>
                </tr>
                <tr class="odd">
                    <td>ContrabandGenerator</td>
                    <td>2</td>
                    <td>2</td>
                </tr>
                <tr>
                    <td>ContrabandGenerator</td>
                    <td>3</td>
                    <td>3</td>
                </tr>
                <tr class="odd">
                    <td>ContrabandGenerator</td>
                    <td>4</td>
                    <td>4</td>
                </tr>
                <tr>
                    <td>ContrabandGenerator</td>
                    <td>5</td>
                    <td>5</td>
                </tr>
                <tr class="odd">
                    <td>ContrabandGenerator</td>
                    <td>6</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>ContrabandGenerator</td>
                    <td>7</td>
                    <td>7</td>
                </tr>
                <tr class="odd">
                    <td>ContrabandGenerator</td>
                    <td>8</td>
                    <td>8</td>
                </tr>
                <tr>
                    <td>ContrabandGenerator</td>
                    <td>9</td>
                    <td>9</td>
                </tr>
                <tr class="odd">
                    <td>ContrabandGenerator</td>
                    <td>10</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>ContrabandStorage</td>
                    <td>2</td>
                    <td>2</td>
                </tr>
                <tr class="odd">
                    <td>ContrabandStorage</td>
                    <td>3</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>ContrabandStorage</td>
                    <td>4</td>
                    <td>4</td>
                </tr>
                <tr class="odd">
                    <td>ContrabandStorage</td>
                    <td>5</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>ContrabandStorage</td>
                    <td>6</td>
                    <td>6</td>
                </tr>
                <tr class="odd">
                    <td>ContrabandStorage</td>
                    <td>7</td>
                    <td>7</td>
                </tr>
                <tr>
                    <td>ContrabandStorage</td>
                    <td>8</td>
                    <td>8</td>
                </tr>
                <tr class="odd">
                    <td>ContrabandStorage</td>
                    <td>9</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>ContrabandStorage</td>
                    <td>10</td>
                    <td>9</td>
                </tr>
                <tr class="odd">
                    <td>ContrabandStorage</td>
                    <td>11</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>ContrabandStorage</td>
                    <td>12</td>
                    <td>9</td>
                </tr>
                <tr class="odd">
                    <td>ContrabandStorage</td>
                    <td>13</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>ContrabandStorage</td>
                    <td>14</td>
                    <td>9</td>
                </tr>
                <tr class="odd">
                    <td>ContrabandStorage</td>
                    <td>15</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>ContrabandStorage</td>
                    <td>16</td>
                    <td>9</td>
                </tr>
                <tr class="odd">
                    <td>ContrabandStorage</td>
                    <td>17</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>CreditGenerator</td>
                    <td>2</td>
                    <td>2</td>
                </tr>
                <tr class="odd">
                    <td>CreditGenerator</td>
                    <td>3</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>CreditGenerator</td>
                    <td>4</td>
                    <td>4</td>
                </tr>
                <tr class="odd">
                    <td>CreditGenerator</td>
                    <td>5</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>CreditGenerator</td>
                    <td>6</td>
                    <td>6</td>
                </tr>
                <tr class="odd">
                    <td>CreditGenerator</td>
                    <td>7</td>
                    <td>7</td>
                </tr>
                <tr>
                    <td>CreditGenerator</td>
                    <td>8</td>
                    <td>8</td>
                </tr>
                <tr class="odd">
                    <td>CreditGenerator</td>
                    <td>9</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>CreditGenerator</td>
                    <td>10</td>
                    <td>10</td>
                </tr>
                <tr class="odd">
                    <td>CreditStorage</td>
                    <td>2</td>
                    <td>2</td>
                </tr>
                <tr>
                    <td>CreditStorage</td>
                    <td>3</td>
                    <td>3</td>
                </tr>
                <tr class="odd">
                    <td>CreditStorage</td>
                    <td>4</td>
                    <td>4</td>
                </tr>
                <tr>
                    <td>CreditStorage</td>
                    <td>5</td>
                    <td>5</td>
                </tr>
                <tr class="odd">
                    <td>CreditStorage</td>
                    <td>6</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>CreditStorage</td>
                    <td>7</td>
                    <td>7</td>
                </tr>
                <tr class="odd">
                    <td>CreditStorage</td>
                    <td>8</td>
                    <td>8</td>
                </tr>
                <tr>
                    <td>CreditStorage</td>
                    <td>9</td>
                    <td>9</td>
                </tr>
                <tr class="odd">
                    <td>CreditStorage</td>
                    <td>10</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>Factory</td>
                    <td>2</td>
                    <td>3</td>
                </tr>
                <tr class="odd">
                    <td>Factory</td>
                    <td>3</td>
                    <td>4</td>
                </tr>
                <tr>
                    <td>Factory</td>
                    <td>4</td>
                    <td>5</td>
                </tr>
                <tr class="odd">
                    <td>Factory</td>
                    <td>5</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>Factory</td>
                    <td>6</td>
                    <td>7</td>
                </tr>
                <tr class="odd">
                    <td>Factory</td>
                    <td>7</td>
                    <td>8</td>
                </tr>
                <tr>
                    <td>Factory</td>
                    <td>8</td>
                    <td>9</td>
                </tr>
                <tr class="odd">
                    <td>Factory</td>
                    <td>9</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>Factory</td>
                    <td>10</td>
                    <td>11</td>
                </tr>
                <tr class="odd">
                    <td>FleetCommand</td>
                    <td>2</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>FleetCommand</td>
                    <td>3</td>
                    <td>4</td>
                </tr>
                <tr class="odd">
                    <td>FleetCommand</td>
                    <td>4</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>FleetCommand</td>
                    <td>5</td>
                    <td>6</td>
                </tr>
                <tr class="odd">
                    <td>FleetCommand</td>
                    <td>6</td>
                    <td>7</td>
                </tr>
                <tr>
                    <td>FleetCommand</td>
                    <td>7</td>
                    <td>8</td>
                </tr>
                <tr class="odd">
                    <td>FleetCommand</td>
                    <td>8</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>FleetCommand</td>
                    <td>9</td>
                    <td>10</td>
                </tr>
                <tr class="odd">
                    <td>FleetCommand</td>
                    <td>10</td>
                    <td>11</td>
                </tr>
                <tr>
                    <td>HQ</td>
                    <td>1</td>
                    <td>20</td>
                </tr>
                <tr class="odd">
                    <td>HQ</td>
                    <td>2</td>
                    <td>40</td>
                </tr>
                <tr>
                    <td>HQ</td>
                    <td>3</td>
                    <td>60</td>
                </tr>
                <tr class="odd">
                    <td>HQ</td>
                    <td>4</td>
                    <td>80</td>
                </tr>
                <tr>
                    <td>HQ</td>
                    <td>5</td>
                    <td>100</td>
                </tr>
                <tr class="odd">
                    <td>HQ</td>
                    <td>6</td>
                    <td>120</td>
                </tr>
                <tr>
                    <td>HQ</td>
                    <td>7</td>
                    <td>140</td>
                </tr>
                <tr class="odd">
                    <td>HQ</td>
                    <td>8</td>
                    <td>160</td>
                </tr>
                <tr>
                    <td>HQ</td>
                    <td>9</td>
                    <td>180</td>
                </tr>
                <tr class="odd">
                    <td>HQ</td>
                    <td>10</td>
                    <td>200</td>
                </tr>
                <tr>
                    <td>MaterialsGenerator</td>
                    <td>2</td>
                    <td>2</td>
                </tr>
                <tr class="odd">
                    <td>MaterialsGenerator</td>
                    <td>3</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>MaterialsGenerator</td>
                    <td>4</td>
                    <td>4</td>
                </tr>
                <tr class="odd">
                    <td>MaterialsGenerator</td>
                    <td>5</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>MaterialsGenerator</td>
                    <td>6</td>
                    <td>6</td>
                </tr>
                <tr class="odd">
                    <td>MaterialsGenerator</td>
                    <td>7</td>
                    <td>7</td>
                </tr>
                <tr>
                    <td>MaterialsGenerator</td>
                    <td>8</td>
                    <td>8</td>
                </tr>
                <tr class="odd">
                    <td>MaterialsGenerator</td>
                    <td>9</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>MaterialsGenerator</td>
                    <td>10</td>
                    <td>10</td>
                </tr>
                <tr class="odd">
                    <td>MaterialsStorage</td>
                    <td>2</td>
                    <td>2</td>
                </tr>
                <tr>
                    <td>MaterialsStorage</td>
                    <td>3</td>
                    <td>3</td>
                </tr>
                <tr class="odd">
                    <td>MaterialsStorage</td>
                    <td>4</td>
                    <td>4</td>
                </tr>
                <tr>
                    <td>MaterialsStorage</td>
                    <td>5</td>
                    <td>5</td>
                </tr>
                <tr class="odd">
                    <td>MaterialsStorage</td>
                    <td>6</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>MaterialsStorage</td>
                    <td>7</td>
                    <td>7</td>
                </tr>
                <tr class="odd">
                    <td>MaterialsStorage</td>
                    <td>8</td>
                    <td>8</td>
                </tr>
                <tr>
                    <td>MaterialsStorage</td>
                    <td>9</td>
                    <td>9</td>
                </tr>
                <tr class="odd">
                    <td>MaterialsStorage</td>
                    <td>10</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>Mortar</td>
                    <td>2</td>
                    <td>30</td>
                </tr>
                <tr class="odd">
                    <td>Mortar</td>
                    <td>3</td>
                    <td>35</td>
                </tr>
                <tr>
                    <td>Mortar</td>
                    <td>4</td>
                    <td>40</td>
                </tr>
                <tr class="odd">
                    <td>Mortar</td>
                    <td>5</td>
                    <td>45</td>
                </tr>
                <tr>
                    <td>Mortar</td>
                    <td>6</td>
                    <td>50</td>
                </tr>
                <tr class="odd">
                    <td>Mortar</td>
                    <td>7</td>
                    <td>55</td>
                </tr>
                <tr>
                    <td>Mortar</td>
                    <td>8</td>
                    <td>60</td>
                </tr>
                <tr class="odd">
                    <td>Mortar</td>
                    <td>9</td>
                    <td>65</td>
                </tr>
                <tr>
                    <td>Mortar</td>
                    <td>10</td>
                    <td>70</td>
                </tr>
                <tr class="odd">
                    <td>NavigationCenter</td>
                    <td>2</td>
                    <td>7</td>
                </tr>
                <tr>
                    <td>NavigationCenter</td>
                    <td>3</td>
                    <td>8</td>
                </tr>
                <tr class="odd">
                    <td>NavigationCenter</td>
                    <td>4</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>NavigationCenter</td>
                    <td>5</td>
                    <td>10</td>
                </tr>
                <tr class="odd">
                    <td>NavigationCenterLocked</td>
                    <td>6</td>
                    <td>11</td>
                </tr>
                <tr>
                    <td>OffenseLab</td>
                    <td>2</td>
                    <td>3</td>
                </tr>
                <tr class="odd">
                    <td>OffenseLab</td>
                    <td>3</td>
                    <td>4</td>
                </tr>
                <tr>
                    <td>OffenseLab</td>
                    <td>4</td>
                    <td>5</td>
                </tr>
                <tr class="odd">
                    <td>OffenseLab</td>
                    <td>5</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>OffenseLab</td>
                    <td>6</td>
                    <td>7</td>
                </tr>
                <tr class="odd">
                    <td>OffenseLab</td>
                    <td>7</td>
                    <td>8</td>
                </tr>
                <tr>
                    <td>OffenseLab</td>
                    <td>8</td>
                    <td>9</td>
                </tr>
                <tr class="odd">
                    <td>OffenseLab</td>
                    <td>9</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>OffenseLab</td>
                    <td>10</td>
                    <td>11</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>2</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>3</td>
                    <td>5</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>4</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>5</td>
                    <td>6</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>6</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>7</td>
                    <td>6</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>8</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>9</td>
                    <td>7</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>10</td>
                    <td>7</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>11</td>
                    <td>7</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>12</td>
                    <td>7</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>13</td>
                    <td>8</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>14</td>
                    <td>8</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>15</td>
                    <td>8</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>16</td>
                    <td>8</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>17</td>
                    <td>9</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>18</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>19</td>
                    <td>9</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>20</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>21</td>
                    <td>10</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>22</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>23</td>
                    <td>10</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>24</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>25</td>
                    <td>11</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>26</td>
                    <td>11</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>27</td>
                    <td>11</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>28</td>
                    <td>11</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>29</td>
                    <td>12</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>30</td>
                    <td>12</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>31</td>
                    <td>12</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>32</td>
                    <td>12</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>33</td>
                    <td>13</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>34</td>
                    <td>13</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>35</td>
                    <td>13</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>36</td>
                    <td>13</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>37</td>
                    <td>14</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>38</td>
                    <td>14</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>39</td>
                    <td>14</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>40</td>
                    <td>14</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>41</td>
                    <td>14</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>42</td>
                    <td>14</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>43</td>
                    <td>14</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>44</td>
                    <td>14</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>45</td>
                    <td>14</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>46</td>
                    <td>14</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>47</td>
                    <td>14</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>48</td>
                    <td>14</td>
                </tr>
                <tr>
                    <td>PlatformDroideka</td>
                    <td>49</td>
                    <td>14</td>
                </tr>
                <tr class="odd">
                    <td>PlatformDroideka</td>
                    <td>50</td>
                    <td>14</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>2</td>
                    <td>5</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>3</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>4</td>
                    <td>5</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>5</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>6</td>
                    <td>6</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>7</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>8</td>
                    <td>6</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>9</td>
                    <td>7</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>10</td>
                    <td>7</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>11</td>
                    <td>7</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>12</td>
                    <td>7</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>13</td>
                    <td>8</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>14</td>
                    <td>8</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>15</td>
                    <td>8</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>16</td>
                    <td>8</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>17</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>18</td>
                    <td>9</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>19</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>20</td>
                    <td>9</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>21</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>22</td>
                    <td>10</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>23</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>24</td>
                    <td>10</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>25</td>
                    <td>11</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>26</td>
                    <td>11</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>27</td>
                    <td>11</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>28</td>
                    <td>11</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>29</td>
                    <td>12</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>30</td>
                    <td>12</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>31</td>
                    <td>12</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>32</td>
                    <td>12</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>33</td>
                    <td>13</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>34</td>
                    <td>13</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>35</td>
                    <td>13</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>36</td>
                    <td>13</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>37</td>
                    <td>14</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>38</td>
                    <td>14</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>39</td>
                    <td>14</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>40</td>
                    <td>14</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>41</td>
                    <td>14</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>42</td>
                    <td>14</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>43</td>
                    <td>14</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>44</td>
                    <td>14</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>45</td>
                    <td>14</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>46</td>
                    <td>14</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>47</td>
                    <td>14</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>48</td>
                    <td>14</td>
                </tr>
                <tr class="odd">
                    <td>PlatformHeavyDroideka</td>
                    <td>49</td>
                    <td>14</td>
                </tr>
                <tr>
                    <td>PlatformHeavyDroideka</td>
                    <td>50</td>
                    <td>14</td>
                </tr>
                <tr class="odd">
                    <td>RapidFireTurret</td>
                    <td>2</td>
                    <td>30</td>
                </tr>
                <tr>
                    <td>RapidFireTurret</td>
                    <td>3</td>
                    <td>35</td>
                </tr>
                <tr class="odd">
                    <td>RapidFireTurret</td>
                    <td>4</td>
                    <td>40</td>
                </tr>
                <tr>
                    <td>RapidFireTurret</td>
                    <td>5</td>
                    <td>45</td>
                </tr>
                <tr class="odd">
                    <td>RapidFireTurret</td>
                    <td>6</td>
                    <td>50</td>
                </tr>
                <tr>
                    <td>RapidFireTurret</td>
                    <td>7</td>
                    <td>55</td>
                </tr>
                <tr class="odd">
                    <td>RapidFireTurret</td>
                    <td>8</td>
                    <td>60</td>
                </tr>
                <tr>
                    <td>RapidFireTurret</td>
                    <td>9</td>
                    <td>65</td>
                </tr>
                <tr class="odd">
                    <td>RapidFireTurret</td>
                    <td>10</td>
                    <td>70</td>
                </tr>
                <tr>
                    <td>RocketTurret</td>
                    <td>2</td>
                    <td>30</td>
                </tr>
                <tr class="odd">
                    <td>RocketTurret</td>
                    <td>3</td>
                    <td>35</td>
                </tr>
                <tr>
                    <td>RocketTurret</td>
                    <td>4</td>
                    <td>40</td>
                </tr>
                <tr class="odd">
                    <td>RocketTurret</td>
                    <td>5</td>
                    <td>45</td>
                </tr>
                <tr>
                    <td>RocketTurret</td>
                    <td>6</td>
                    <td>50</td>
                </tr>
                <tr class="odd">
                    <td>RocketTurret</td>
                    <td>7</td>
                    <td>55</td>
                </tr>
                <tr>
                    <td>RocketTurret</td>
                    <td>8</td>
                    <td>60</td>
                </tr>
                <tr class="odd">
                    <td>RocketTurret</td>
                    <td>9</td>
                    <td>65</td>
                </tr>
                <tr>
                    <td>RocketTurret</td>
                    <td>10</td>
                    <td>70</td>
                </tr>
                <tr class="odd">
                    <td>ShieldGenerator</td>
                    <td>2</td>
                    <td>8</td>
                </tr>
                <tr>
                    <td>ShieldGenerator</td>
                    <td>3</td>
                    <td>11</td>
                </tr>
                <tr class="odd">
                    <td>ShieldGenerator</td>
                    <td>4</td>
                    <td>13</td>
                </tr>
                <tr>
                    <td>ShieldGenerator</td>
                    <td>5</td>
                    <td>16</td>
                </tr>
                <tr class="odd">
                    <td>ShieldGenerator</td>
                    <td>6</td>
                    <td>18</td>
                </tr>
                <tr>
                    <td>ShieldGenerator</td>
                    <td>7</td>
                    <td>21</td>
                </tr>
                <tr class="odd">
                    <td>ShieldGenerator</td>
                    <td>8</td>
                    <td>23</td>
                </tr>
                <tr>
                    <td>ShieldGenerator</td>
                    <td>9</td>
                    <td>26</td>
                </tr>
                <tr class="odd">
                    <td>ShieldGenerator</td>
                    <td>10</td>
                    <td>28</td>
                </tr>
                <tr>
                    <td>SonicTurret</td>
                    <td>2</td>
                    <td>30</td>
                </tr>
                <tr class="odd">
                    <td>SonicTurret</td>
                    <td>3</td>
                    <td>35</td>
                </tr>
                <tr>
                    <td>SonicTurret</td>
                    <td>4</td>
                    <td>40</td>
                </tr>
                <tr class="odd">
                    <td>SonicTurret</td>
                    <td>5</td>
                    <td>45</td>
                </tr>
                <tr>
                    <td>SonicTurret</td>
                    <td>6</td>
                    <td>50</td>
                </tr>
                <tr class="odd">
                    <td>SonicTurret</td>
                    <td>7</td>
                    <td>55</td>
                </tr>
                <tr>
                    <td>SonicTurret</td>
                    <td>8</td>
                    <td>60</td>
                </tr>
                <tr class="odd">
                    <td>SonicTurret</td>
                    <td>9</td>
                    <td>65</td>
                </tr>
                <tr>
                    <td>SonicTurret</td>
                    <td>10</td>
                    <td>70</td>
                </tr>
                <tr class="odd">
                    <td>SquadBuilding</td>
                    <td>1</td>
                    <td>25</td>
                </tr>
                <tr>
                    <td>SquadBuilding</td>
                    <td>2</td>
                    <td>50</td>
                </tr>
                <tr class="odd">
                    <td>SquadBuilding</td>
                    <td>3</td>
                    <td>75</td>
                </tr>
                <tr>
                    <td>SquadBuilding</td>
                    <td>4</td>
                    <td>100</td>
                </tr>
                <tr class="odd">
                    <td>SquadBuilding</td>
                    <td>5</td>
                    <td>125</td>
                </tr>
                <tr>
                    <td>SquadBuilding</td>
                    <td>6</td>
                    <td>150</td>
                </tr>
                <tr class="odd">
                    <td>SquadBuilding</td>
                    <td>7</td>
                    <td>175</td>
                </tr>
                <tr>
                    <td>SquadBuilding</td>
                    <td>8</td>
                    <td>200</td>
                </tr>
                <tr class="odd">
                    <td>SquadBuilding</td>
                    <td>9</td>
                    <td>225</td>
                </tr>
                <tr>
                    <td>SquadBuilding</td>
                    <td>10</td>
                    <td>250</td>
                </tr>
                <tr class="odd">
                    <td>Starport</td>
                    <td>2</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>Starport</td>
                    <td>3</td>
                    <td>4</td>
                </tr>
                <tr class="odd">
                    <td>Starport</td>
                    <td>4</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Starport</td>
                    <td>5</td>
                    <td>6</td>
                </tr>
                <tr class="odd">
                    <td>Starport</td>
                    <td>6</td>
                    <td>7</td>
                </tr>
                <tr>
                    <td>Starport</td>
                    <td>7</td>
                    <td>8</td>
                </tr>
                <tr class="odd">
                    <td>Starport</td>
                    <td>8</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>Starport</td>
                    <td>9</td>
                    <td>10</td>
                </tr>
                <tr class="odd">
                    <td>Starport</td>
                    <td>10</td>
                    <td>11</td>
                </tr>
                <tr>
                    <td>TacticalCommand</td>
                    <td>2</td>
                    <td>3</td>
                </tr>
                <tr class="odd">
                    <td>TacticalCommand</td>
                    <td>3</td>
                    <td>4</td>
                </tr>
                <tr>
                    <td>TacticalCommand</td>
                    <td>4</td>
                    <td>5</td>
                </tr>
                <tr class="odd">
                    <td>TacticalCommand</td>
                    <td>5</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>TacticalCommand</td>
                    <td>6</td>
                    <td>7</td>
                </tr>
                <tr class="odd">
                    <td>TacticalCommand</td>
                    <td>7</td>
                    <td>8</td>
                </tr>
                <tr>
                    <td>TacticalCommand</td>
                    <td>8</td>
                    <td>9</td>
                </tr>
                <tr class="odd">
                    <td>TacticalCommand</td>
                    <td>9</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>TacticalCommand</td>
                    <td>10</td>
                    <td>11</td>
                </tr>
                <tr class="odd">
                    <td>TrapDropship</td>
                    <td>2</td>
                    <td>32</td>
                </tr>
                <tr>
                    <td>TrapDropship</td>
                    <td>3</td>
                    <td>33</td>
                </tr>
                <tr class="odd">
                    <td>TrapDropship</td>
                    <td>4</td>
                    <td>34</td>
                </tr>
                <tr>
                    <td>TrapDropship</td>
                    <td>5</td>
                    <td>35</td>
                </tr>
                <tr class="odd">
                    <td>TrapDropship</td>
                    <td>6</td>
                    <td>36</td>
                </tr>
                <tr>
                    <td>TrapDropship</td>
                    <td>7</td>
                    <td>37</td>
                </tr>
                <tr class="odd">
                    <td>TrapDropship</td>
                    <td>8</td>
                    <td>38</td>
                </tr>
                <tr>
                    <td>TrapDropship</td>
                    <td>9</td>
                    <td>39</td>
                </tr>
                <tr class="odd">
                    <td>TrapDropship</td>
                    <td>10</td>
                    <td>40</td>
                </tr>
                <tr>
                    <td>TrapStrikeAOE</td>
                    <td>2</td>
                    <td>32</td>
                </tr>
                <tr class="odd">
                    <td>TrapStrikeAOE</td>
                    <td>3</td>
                    <td>33</td>
                </tr>
                <tr>
                    <td>TrapStrikeAOE</td>
                    <td>4</td>
                    <td>34</td>
                </tr>
                <tr class="odd">
                    <td>TrapStrikeAOE</td>
                    <td>5</td>
                    <td>35</td>
                </tr>
                <tr>
                    <td>TrapStrikeAOE</td>
                    <td>6</td>
                    <td>36</td>
                </tr>
                <tr class="odd">
                    <td>TrapStrikeAOE</td>
                    <td>7</td>
                    <td>37</td>
                </tr>
                <tr>
                    <td>TrapStrikeAOE</td>
                    <td>8</td>
                    <td>38</td>
                </tr>
                <tr class="odd">
                    <td>TrapStrikeAOE</td>
                    <td>9</td>
                    <td>39</td>
                </tr>
                <tr>
                    <td>TrapStrikeAOE</td>
                    <td>10</td>
                    <td>40</td>
                </tr>
                <tr class="odd">
                    <td>TrapStrikeGeneric</td>
                    <td>2</td>
                    <td>32</td>
                </tr>
                <tr>
                    <td>TrapStrikeGeneric</td>
                    <td>3</td>
                    <td>33</td>
                </tr>
                <tr class="odd">
                    <td>TrapStrikeGeneric</td>
                    <td>4</td>
                    <td>34</td>
                </tr>
                <tr>
                    <td>TrapStrikeGeneric</td>
                    <td>5</td>
                    <td>35</td>
                </tr>
                <tr class="odd">
                    <td>TrapStrikeGeneric</td>
                    <td>6</td>
                    <td>36</td>
                </tr>
                <tr>
                    <td>TrapStrikeGeneric</td>
                    <td>7</td>
                    <td>37</td>
                </tr>
                <tr class="odd">
                    <td>TrapStrikeGeneric</td>
                    <td>8</td>
                    <td>38</td>
                </tr>
                <tr>
                    <td>TrapStrikeGeneric</td>
                    <td>9</td>
                    <td>39</td>
                </tr>
                <tr class="odd">
                    <td>TrapStrikeGeneric</td>
                    <td>10</td>
                    <td>40</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
